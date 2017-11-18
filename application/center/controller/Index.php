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
//        ])->field('b.ip,b.notify_port')->distinct(true)->select();
//        halt($a);
        $service = Db::name('service')->where([
            ['name','in','UserService,LoginService'],
            ['status','=',1]
        ])
        ->field('id,start_time,stop_time,status',true)
            ->order('name')
        ->select();
        halt($service);
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