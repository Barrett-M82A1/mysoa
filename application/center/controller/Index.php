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
//        $a = Db::name('service')->alias('a')->join('consumer b','b.service = a.name')->where([
//            ['a.name','in','UserService,LoginService'],
//            ['b.status','=',1]
//        ])->select();
//        halt($a);

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