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
    public static function register(array $data) : void
    {
        // 检测服务是否存在
        $check = Db::name('service')
                ->where(['service'=>$data['service','ip'=>$data['ip'],'port'=>$data['port']]])
                ->find();
        if (!$check){
            #不存在的话则插入服务表
        }else{
            #存在的话则更新指定内容
        }
        self::pushConfig($data);
    }

    /**
     * 推送服务配置至消费者
     * @param $data
     */
    public static function pushService(array $data) : void
    {
        // 查询使用该服务的消费者
        $consumer = Db::name('consumer')
                    ->alias('a')
                    ->where(['a.service'=>$data['service']])
                    ->join('service b','a.app_name = b.app_name')
                    ->field('b.id,b.notify_port')
                    ->select();
        if (!$consumer){
            #没有数据 日志记录
        }

        // 获取该服务信息
        $service = Db::name('service')->where(['name'=>$data['service']])->select();

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
        }
    }
}