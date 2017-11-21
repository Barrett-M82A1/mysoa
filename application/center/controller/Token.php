<?php
/**
 * MySoa  - 控制器基类(需要登录)
 */

namespace app\center\controller;
use think\facade\Session;
use think\facade\Config;

class Token extends Common{

    /**
     * 左侧导航
     * @var array
     */
    protected $nav;

    /**
     * 用户Session
     * @var array
     */
    protected $token;

    protected function initialize()
    {
        // 获取Session
        $this->token  = Session::get('token');

        // 检测缓存是否有效
        if (empty($this->token)) {
            return $this->redirect('Login/index');
        }

        // 设置页面导航
        $this->nav = Config::pull('navigation');
        if ($this->request->controller() === 'Index'){
            $this->assign('nav',$this->nav['service']);
        }else{
            $this->assign('nav',$this->nav[$this->request->controller()]);
        }
    }

    /**
     * 设置页面标题
     */
    public function setTitle($title = "MySoa服务治理中心"){
        $this->assign('title',$title);
    }
}