<?php
namespace app\center\controller;

use app\center\logic\Service as ServiceLogic;

class Service extends Token
{
    /**
     * 首页
     */
    public function index()
    {
        $this->setTitle("服务治理");
        return $this->fetch();
    }

    /**
     * 服务详情页
     */
    public function info(){
        $this->setTitle("服务详情");
        return $this->fetch();
    }

    /**
     * 服务列表
     */
    public function serviceList(){
        $service = new ServiceLogic();
        $data = $service->queryList();
        return json([
            'code'  =>  1,
            'msg'   =>  $data['msg'],
            'total' =>  $data['data']->total(),
            'data'  =>  $data['data']->getCollection()
        ]);
    }

    /**
     * 获取实例列表
     */
    public function exampleList(){
        $service = new ServiceLogic();
        $data = $service->queryExample($this->request->param('name'));
        return json([
            'code'  =>  1,
            'msg'   =>  $data['msg'],
            'total' =>  $data['data']->total(),
            'data'  =>  $data['data']->getCollection()
        ]);
    }

    /**
     * 获取实例信息
     */
    public function queryInfo(){
        $service = new ServiceLogic();
        $data = $service->queryInfo($this->request->param('name'));
        $this->jsonReturn($data);
    }

    /**
     * 设置实例
     */
    public function setExample(){
        $serviceData = new \app\center\data\Service();
        $check = $serviceData->checkSet($this->request->param());
        $this->jsonError($check);

        $service = new \app\center\service\Service();
        $result = $service->setService($check['data']['param'],$check['data']['id']);
        $this->jsonReturn($result);
    }
}