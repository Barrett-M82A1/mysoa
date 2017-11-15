<?php
/**
 * 服务控制中心
 */
namespace app\center\soa;

use think\Db;

class Center {
    /**
     * 服务注册
     */
    public static function register(array $data =[])
    {
        $set = [
            // 服务启动时间
            'start_time'    =>  date('Y-m-d H:i:s',time()),

            // 服务状态
            'status'        =>  1
        ];

        $lists = $data['name'];

        unset($data['method'],$data['name']);

        foreach ($lists as $key => $value){
            // 检测服务是否存在
            $check = Db::name('service')->where([
                ['name','=',$value],
                ['ip','=',$data['ip']],
                ['port','=',$data['port']]
            ])->find();

            if (!$check){
                Db::name('service')->insert(array_merge($data,$set,['name'=>$value]));
            }else{
                Db::name('service')->where('id','=',$check['id'])->update(array_merge($data,$set,['weight'=>50]));
            }
        }

        // 通知服务消费者
        self::pushService($lists);
    }

    /**
     * 订阅服务
     */
    public static function subscribe(array $data =[]){
        // 服务鉴权

        // 初始化订阅状态
        Db::name('consumer')->where([
            ['app_name','=',$data['app_name']],
            ['ip','=',$data['ip']]
        ])->update(['status'=>0]);

        $lists = $data['service'];

        unset($data['method'],$data['service']);

        // 注册服务订阅者
        foreach ($lists as $key => $value){
            $check = Db::name('consumer')->where([
                ['app_name','=',$data['app_name']],
                ['ip','=',$data['ip']],
                ['port','=',$data['port']],
                ['service','=',$value]
            ])->find();

            // 更新服务订阅者
            if ($check){
                Db::name('consumer')
                    ->where('id','=',$check['id'])
                    ->update(['status'=>1]);
            }else{
                // 新增服务订阅者
                Db::name('consumer')->insert(array_merge($data,['service'=>$value]));
            }
        }

        // 通知服务消费者
        self::pushService($lists);
    }

    /**
     * 推送服务配置至消费者
     * @param array $service_name 服务名称（可传入多个）
     */
    public static function pushService(array $service_name = [])
    {
        // 查询使用该服务的消费者
        $consumer = Db::name('service')->alias('a')
        ->join('consumer b','b.service = a.name')
        ->where([
            ['a.name','in',implode($service_name,',')],
            ['b.status','=',1]
        ])
        ->field('b.ip,b.notify_port')
        ->distinct(true)
        ->select();

        if (!empty($consumer)){
            // 获取可用服务列表
            $service = Db::name('service')->where([
                ['name','in',implode($service_name,',')],
                ['status','=',1]
            ])
            ->field('id,start_time,stop_time,status',true)
            ->order('name')
            ->select();

            $service = json_encode($service);

            // 推送给个消费者
            foreach ($consumer as $key => $item) {
                $client = new \swoole_client(SWOOLE_SOCK_TCP);
                $client->connect($item['ip'], $item['notify_port'], 0.5);


                $str = pack('N', strlen($service)).$service;
                $client->send($str);

                #日志记录推送
            }
        }else{
            echo "MySoa : The request is successful, but the service consumer does not exist!\n";
        }
    }
}