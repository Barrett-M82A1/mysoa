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
     * 获取消费者列表
     * @param  string $name     服务名称
     * @return array  $result   消费者列表
     */
    public function queryConsumer(string $name) : array
    {
        $result = $this->alias('a')
                ->join('consumer b','a.name = b.service')
                ->where([['b.status','=',1],['a.name','=',$name]])
                ->field('b.*')
                ->order('b.id desc')
                ->paginate(10,false);

        if (count($result) === 0){
            return ['status'=>false,'msg'=>'未存在服务！','data'=>''];
        }

        return ['status'=>true,'msg'=>'查询成功！','data'=>$result];
    }

    /**
     * 获取实例统计信息
     * @param  string $param['username'] 用户名
     * @param  string $param['password'] 登录密码
     * @return array  $result['uid']     用户UID
     */
    public function queryInfo(string $name) : array
    {
        // 统计信息
        $count = [
            'count'     =>  $this->where('name','=',$name)->count(),
            'run'       =>  $this->where([['name','=',$name],['status','=',1]])->count(),
            'error'     =>  $this->where([['name','=',$name],['status','=',2]])->count(),
            'del'       =>  $this->where([['name','=',$name],['status','=',0]])->count(),
            'consumer'  =>  $this->table('consumer')->where([['service','=',$name],['status','=',1]])->count()
        ];

        // 其他服务信息
        $category = $this->table('category')
                    ->alias('a')
                    ->join('category_service b','a.id = b.cid')
                    ->where([['a.name','=',$name]])
                    ->field('a.name as category')
                    ->find();
        if (!$category){
            $category = ['category'=>''];
        }

        return ['status'=>true,'msg'=>'查询成功！','data'=>array_merge($count,$category)];
    }
}