<?php
/**
 * MySoa  - 控制器基类
 */
namespace app\center\controller;

use think\Controller;
use think\exception\HttpResponseException;

class Common extends Controller{

    /**
     * 错误输出
     * @param  array $data 业务处理结果
     * @param  int   $code 错误代码
     * @return void
     */
    public function jsonError($data,$code = 0)
    {
        if (!$data['status']){
            $this->result($data['data'],$code,$data['msg'],'json');
        }
    }

    /**
     * 分页数据输出
     * @param  array $data 业务处理结果
     * @param  int   $code 错误代码
     */
    public function pageReturn($data,$code = 0)
    {
        if($data['status']){
            $code = 1;
        }
        $response = json([
            'code'  =>  $code,
            'msg'   =>  $data['msg'],
            'total' =>  $data['data']->total(),
            'data'  =>  $data['data']->getCollection()
        ]);
        throw new HttpResponseException($response);
    }

    /**
     * 通用输出
     * @param  array $data  业务处理结果
     * @param  bool  $judge 是否原样输出
     * @return void
     */
    protected function jsonReturn($data,$judge = false)
    {
        // 原样输出
        if ($judge){
            $this->result($data,0,'success','json');
        }

        // 判断输出
        if (!$data['status']){
            $this->result($data['data'],0,$data['msg'],'json');
        }

        $this->result($data['data'],1,$data['msg'],'json');
    }

    /**
     * 空操作重定向
     */
    public function _empty()
    {
        return $this->redirect('Index/index');
    }
}