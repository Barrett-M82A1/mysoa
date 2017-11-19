<?php

namespace app\center\controller;

class Login extends Common
{
    /**
     * 登录页面
     */
    public function index()
    {
        return $this->fetch('public/index');
    }

    /**
     * 登录逻辑
     */
    public function onLogin()
    {
        // 获取数据
        $param = $this->request->param();

        // 静态校验
        $loginData = new \app\center\data\Login;
        $check = $loginData->checkLogin($param);
        $this->jsonError($check);

        // 流程处理
        $loginService = new \app\center\service\Login;
        $result = $loginService->onLogin($check['data']);
        $this->jsonReturn($result);
    }
}