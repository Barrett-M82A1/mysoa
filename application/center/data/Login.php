<?php
/**
 * MySoa  - 登录校验
 */
namespace app\center\data;
use think\Validate;

class Login {
    /**
     * 登录提交数据验证
     * @param string $data['username'] 用户名
     * @param string $data['password'] 密码
     * @return array
     */
    public function checkLogin(array $data) : array
    {
        $validate = Validate::make([
            'username'  =>  'require',
            'password'  =>  'require',
        ],[
            'username.require'  =>  "请填写您的登录用户名！",
            'password.require'  =>  "请填写您的登录密码！",
        ]);

        if(!$validate->check($data)) {
            return ['status'=>false,'msg'=>$validate->getError(),'data'=>''];
        }

        return ['status'=>true,'msg'=>'验证通过','data'=>$data];
    }
}