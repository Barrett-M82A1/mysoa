<?php
/**
 * MySoa  - 登录流程处理
 */
namespace app\center\service;
use think\facade\Session;

class Login {

    /**
     * 管理员登录
     * @param string $param['username'] 用户名
     * @param string $param['password'] 登录密码
     * @param string $ip                登录IP
     * @return array $result['uid']     用户UID
     */
    public function onLogin(array $param,string $ip){
        $adminLogic = new \app\center\logic\Admin;

        // 检测用户是否存在
        $check = $adminLogic->checkUserName($param['username']);

        if (!$check['status']){
            return $check;
        }

        // 密码验证
        if (!password_verify($param['password'],$check['data']['password'])){
            return ['status'=>false,'msg'=>'登录失败','data'=>''];
        }

        // 更新登录IP
        $adminLogic->save(['login_ip'=>$ip],['uid'=>$check['data']['uid']]);

        // 更新SESSION
        Session::set('token',['uid'=>$check['data']['uid'],'username'=>$check['data']['username']]);

        return ['status'=>true,'msg'=>'登录成功','data'=>url('Index/index')];
    }
}