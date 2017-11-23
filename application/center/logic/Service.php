<?php
/**
 * MySoa  - 服务提供方
 */
namespace app\center\logic;

class Service extends Common{

    /**
     * 获取服务列表
     * @param  string $param['username'] 用户名
     * @param  string $param['password'] 登录密码
     * @return array  $result['uid']     用户UID
     */
    public function queryList() : array
    {
        // 创建用户
        $result = $this->alias('a')
                ->field('a.name,a.id,COUNT(*) as num')
                ->group('a.name')
                ->paginate(10,false);

        if (count($result) === 0){
            return ['status'=>false,'msg'=>'未存在服务！','data'=>''];
        }

        return ['status'=>true,'msg'=>'查询成功！','data'=>$result];
    }

    /**
     * 获取实例列表
     * @param  string $param['username'] 用户名
     * @param  string $param['password'] 登录密码
     * @return array  $result['uid']     用户UID
     */
    public function queryExample(string $name) : array
    {
        // 创建用户
        $result = $this->where('name','=',$name)->paginate(5,false);

        if (count($result) === 0){
            return ['status'=>false,'msg'=>'未存在服务！','data'=>''];
        }

        return ['status'=>true,'msg'=>'查询成功！','data'=>$result];
    }

    /**
     * 检测用户是否存在
     * @param  string $userName      用户名
     * @return array  $result['uid'] 用户UID
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