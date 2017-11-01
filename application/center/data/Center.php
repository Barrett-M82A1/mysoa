<?php
/**
 * MySoa  - 数据验证器
 */
namespace app\center\data;
use think\Validate;

class Center {
    /**
     * 通信协议内容效验
     * @param string $data['name']      服务提供者
     * @param string $data['email']     服务提供者邮箱
     * @param string $data['ip']        服务IP
     * @param string $data['method']    请求服务中心的方法
     * @param string $data['out_time']  响应超时时间
     * @param string $data['port']      RPC端口
     * @param string $data['service']   服务名称
     * @return array
     */
    public function checkPushConfig(string $value) : array
    {
        $data = json_decode($value,true);

        if (!is_array($data) || empty($data)){
            return ['status'=>false,'msg'=>'参数错误','data'=>''];
        }

        $validate   = Validate::make([
            'name'      =>  'require',
            'email'     =>  'require|email',
            'ip'        =>  'require|ip',
            'method'    =>  'require',
            'out_time'  =>  'require|number',
            'port'      =>  'require|number',
            'service'   =>  'require'
        ],[
            'name.require'      =>  'The [name] parameter cannot be empty!',
            'email.require'     =>  'The [email] parameter cannot be empty!',
            'email.email'       =>  'The [email] parameter is incorrect!',
            'ip.require'        =>  'The [ip] parameter cannot be empty!',
            'ip.ip'             =>  'The [ip] parameter is incorrect!',
            'method.require'    =>  'The [method] parameter cannot be empty!',
            'out_time.require'  =>  'The [out_time] parameter cannot be empty!',
            'out_time.number'   =>  'The [number] parameter is incorrect!',
            'port.require'      =>  'The [port] parameter cannot be empty!',
            'port.number'       =>  'The [port] parameter is incorrect!',
            'service.require'   =>  'The [service] parameter cannot be empty!',
            'service.number'    =>  'The [service] parameter is incorrect!'
        ]);

        if(!$validate->check($data)) {
            return ['status'=>false,'msg'=>$validate->getError(),'data'=>''];
        }

        return ['status'=>true,'msg'=>'验证通过','data'=>$data];
    }
}