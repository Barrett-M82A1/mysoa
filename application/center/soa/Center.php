<?php
/**
 * TCP控制中心
 */
namespace app\center\soa;

use think\Db;

class Center {
    /**
     * 服务注册
     */
    public static function register(array $data)
    {
        $set = [
            // 设置服务启动时间
            'start_time'    =>  date('Y-m-d H:i:s',time()),
            // 设置服务状态
            'status'        =>  1
        ];

        // 检测服务是否存在
        $check = Db::name('service')->where([
            ['name','=',$data['name']],
            ['ip','=',$data['ip']],
            ['port','=',$data['port']]
        ])->find();

        unset($data['method']);
        if (!$check){
            Db::name('service')->insert(array_merge($data,$set));
        }else{
            Db::name('service')->where('id','=',$check['id'])->update(array_merge($data,$set));
        }

        // 通知服务消费者
        self::pushService($data);
    }

    /**
     * 订阅服务
     */
    public static function subscribe(array $data){
        // 服务鉴权
        // 查询可用服务
        $service = Db::name('service')->where()->select();
    }

    /**
     * 推送服务配置至消费者
     */
    public static function pushService(array $data)
    {
        // 查询使用该服务的消费者
        $consumer = Db::name('consumer')
                    ->alias('a')
                    ->where('a.service','=',$data['name'])
                    ->join('service b','a.service = b.name')
                    ->field('b.id,b.notify_port')
                    ->select();

        if ($consumer){
            // 获取可用服务列表
            $service = Db::name('service')->where('name','=',$data['name'],'status','=',1)->select();

            // 推送给个消费者
            foreach ($consumer as $item) {
                $client = new \swoole_client(SWOOLE_SOCK_TCP);
                $client->connect($item['ip'], $item['notify_port'], 0.5);
                $msg = json_encode([
                    'action'    => 'configUpdate',
                    'data'      => $service,
                ]);
                $str = pack('N', strlen($msg)) . $msg;
                $client->send($str);
                echo 'Mysoa : push '.$item['ip'].':'.$item['notify_port'];
            }
        }else{
            echo "MySoa : The request is successful, but the service consumer does not exist!\n";
        }
    }
}