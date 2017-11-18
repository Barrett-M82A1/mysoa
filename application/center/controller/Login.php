<?php
namespace app\center\controller;
use think\Controller;

class Login extends Controller
{
    /**
     * 登录页面
     */
    public function index()
    {
        return $this->fetch('public/index');
    }
}