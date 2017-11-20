<?php
/**
 * MySoa  - 控制器基类(需要登录)
 */

namespace app\center\controller;
use think\facade\Session;

class Token extends Common{

    protected $token;

    protected function initialize()
    {
        //获取Session
        $this->token  = Session::get('token');

        //检测缓存是否有效
        if (empty($this->token)) {
            return $this->redirect('Login/index');
        }
    }
}