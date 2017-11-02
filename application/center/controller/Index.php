<?php
namespace app\center\controller;
use think\Controller;
use think\Db;
class Index extends Controller
{
    /**
     * 首页
     */
    public function index()
    {
        $result = Db::name('service')->where([
            ['name','=',1],
            ['ip','=',2],
            ['port','=',3]
        ])->find();halt($result);
        return $this->fetch();
    }

    /**
     * 服务查询
     */
    public function queryService(){

    }

    /**
     *
     */
}