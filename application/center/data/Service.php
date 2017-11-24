<?php
/**
 * MySoa  - 服务治理数据校验
 */
namespace app\center\data;
use think\Validate;

class Service {
    /**
     * 设置服务信息
     * @param int $data['id']       需要更新的服务ID
     * @param int $data['weight']   服务权重
     * @param int $data['satus']    服务状态
     * @param int $data['out_time'] 超时时间
     * @return array
     */
    public function checkSet(array $data) : array
    {
        $validate = Validate::make([
            'id'        =>  'require|number',
            'weight'    =>  'number|between:1,100',
            'status'    =>  'bool',
            'out_time'  =>  'number|gt:0'
        ],[
            'id.require'        =>  "关键参数丢失",
            'id.number'         =>  "关键参数错误",
            'weight.number'     =>  "权重必须为整数！",
            'weight.between'    =>  "权重只能填写1-100之间的正整数！",
            'out_time.number'   =>  "超时时间必须为整数！",
            'out_time.gt'       =>  "超时时间只能填写1-100之间的正整数！",
            'status.bool'    =>  "参数错误"
        ]);

        if(!$validate->check($data)) {
            return ['status'=>false,'msg'=>$validate->getError(),'data'=>''];
        }

        $id = $data['id'];
        unset($data['id']);
        return ['status'=>true,'msg'=>'验证通过','data'=>['param'=>$data,'id'=>$id]];
    }
}