<?php
/**
 * MySoa  - 服务流程处理
 */
namespace app\center\service;
use think\Model;
class Service extends Model{

    /**
     * 设置服务信息
     */
    public function setService(array $param,string $id) : array
    {
        $serviceLogic = new \app\center\logic\Service();

        $info = $serviceLogic->getDataById($id);
        if (!$info['status']){
            return ['status'=>false,'msg'=>'服务不存在！','data'=>''];
        }

        $center = new \app\center\soa\Center();
        $this->startTrans();

        // 设置服务信息
        $set = $serviceLogic->save($param,['id'=>$id]);


        try {
            $center->pushService([$info['data']['name']]);
        } catch (Exception $e) {
            $this->rollback();
            return ['status'=>false,'msg'=>$e->getMessage(),'data'=>''];
        }

        if (!$set){
            return ['status'=>false,'msg'=>'设置失败','data'=>''];
        }
        $this->commit();
        return ['status'=>true,'msg'=>'设置成功，配置已成功推送至消费者！','data'=>''];
    }
}