<?php

namespace app\center\controller;
use think\Controller;
class Common extends Controller{

    /**
     * 错误输出
     * @param  array $data 业务处理结果
     * @param  int   $code 错误代码
     * @return void
     */
    protected function jsonError($data,$code = 0) : void
    {
        if (!$data['status']){
            $this->result($data['data'],$code,$data['msg'],'json');
        }
    }

    /**
     * 通用输出
     * @param  array $data 业务处理结果
     * @return void
     */
    protected function jsonReturn($data) : void
    {
        // 判断输出
        if (isset($data['status']) && !$data['status']){
            $this->result($data['data'],0,$data['msg'],'json');
        }
        $this->result($data['data'],1,'success','json');
    }
}