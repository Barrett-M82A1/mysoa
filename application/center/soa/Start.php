<?php
/**
 * 启动swoole
 */
namespace app\center\soa;

use app\center\soa\Center;
use think\console\{Command,Input,Output};

class Start extends Command
{
    protected $server;

    // 命令行配置函数
    protected function configure()
    {
        // 设置启动命令以及备注
        $this->setName('start')->setDescription('Start swoole server!');
    }

    // 设置命令返回信息
    protected function execute(Input $input, Output $output)
    {

        $this->server = new \swoole_server('0.0.0.0', 8081);

        $this->server->on('Start', [$this, 'onStart']);
        $this->server->on('Connect', [$this, 'onConnect']);
        $this->server->on('Receive', [$this, 'onReceive']);
        $this->server->on('Close', [$this, 'onClose']);

        $this->server->start();
    }

    // 主进程启动时回调函数
    public function onStart(\swoole_server $server)
    {
        echo "MySoa : Swoole server is running :)\n";
    }

    // 建立连接时回调函数
    public function onConnect(\swoole_server $server, $fd, $from_id)
    {
        echo "MySoa : Connection open -> {$fd}\n";
    }

    // 收到信息时回调函数
    public function onReceive(\swoole_server $server, int $fd, int $reactor_id, string $data)
    {
        $CenterData = new \app\center\data\Center;
        $check = $CenterData->checkPushConfig(substr($data, 4));
        if (!$check['status']){
            echo "MySoa : Error Data validation does not pass\n Info : {$check['msg']} \n";
            #日志记录
            // 操作完毕关闭会话连接
            return $server->close($fd);
        }

        // 调用soa\Center内的操作
        call_user_func_array([__NAMESPACE__ .'\Center',$check['data']['method']],[$check['data']]);

        $server->close($fd);
    }

    // 关闭连时回调函数
    public function onClose(\swoole_server $server, int $fd, int $reactorId)
    {
        echo "MySoa : Connection close -> {$fd}\n";
    }
}