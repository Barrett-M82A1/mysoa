<?php
namespace app\center\controller;

class Index extends Token
{
    /**
     * 首页
     */
    public function index()
    {
        $this->setTitle("首页");
        return $this->fetch();
    }
}