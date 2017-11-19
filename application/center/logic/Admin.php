<?php
/**
 * MySoa  - 管理员logic
 */
namespace app\center\logic;

class Admin extends Common{

    /**
     * 创建管理员
     * @param  string $param['username'] 用户名
     * @param  string $param['password'] 登录密码
     * @return array $result['uid']      用户UID
     */
    public function createAdmin(array $param) : array
    {
        // 创建用户
        $result = $this->data(array_merge($param,['add_time'=>now()]))->save();

        if (!$result){
            return ['status'=>false,'msg'=>'创建用户失败！','data'=>''];
        }

        return ['status'=>true,'msg'=>'创建用户成功！','data'=>$result->uid];
    }

    /**
     * 检测用户是否存在
     * @param string $userName      用户名
     * @return array $result['uid'] 用户UID
     */
    public function checkUserName(string $userName) : array
    {
        $check = $this->where('username','eq',$userName)->find();
        if (!$check){
            return ['status'=>false,'msg'=>'管理员不存在！','data'=>''];
        }
        return ['status'=>true,'msg'=>'检测通过','data'=>$check];
    }
}