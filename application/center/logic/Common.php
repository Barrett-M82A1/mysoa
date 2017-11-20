<?php
// +----------------------------------------------------------------------
// | Description: MySoa 公共模型,所有logic都可继承此模型
// +----------------------------------------------------------------------
// | $UserLogic = new UserLogic;
// | $data = $UserLogic->createData($param);
// | $this->jsonReturn($data);
// +----------------------------------------------------------------------

namespace app\center\logic;
use think\Model;

class Common extends Model {

    /**
     * 写入数据
     * @param  array $param  入库数据
     * @return array $result 处理结果
     */
    public function createData(array $param) : array
    {
        $result = $this->data($param)->isUpdate(false)->save();
        if (!$result) {
            return ['status'=>false,'msg'=>'添加失败','data'=>10000];
        }
        return ['status'=>true,'msg'=>'操作成功','data'=>$this];
    }

    /**
     * 批量写入数据
     * @param  array $param  入库数据
     * @return array $result 处理结果
     */
    public function createDataAll(array $param) : array
    {
        $result = $this->isUpdate(false)->saveAll($param);
        if ($result) {
            return ['status'=>false,'msg'=>'添加失败','data'=>10000];
        }
        return ['status'=>true,'msg'=>'操作成功','data'=>$this];
    }

    /**
     * 根据主键获取详情 - 单条记录
     * @param  integer $id    当前操作表的主键
     * @return array   $data  获取结果
     */
    public function getDataById(int $id) : array
    {
        $data = $this->get($id);
        if (!$data) {
            return ['status'=>false,'msg'=>'获取失败','data'=>10007];
        }
        return ['status'=>true,'msg'=>'操作成功','data'=>$data];
    }

    /**
     * 更新数据
     * @param  array   $param  需要更新的数据
     * @param  integer $id     当前操作表的主键
     * @return array   $result 处理结果:如果判断pdo报错请验证status，判断是否有更新判断data,如果大于0则更新成功
     */
    public function updateDataById(array $param,int $id) : array
    {
        $checkData = $this->get($id);
        if (!$checkData) {
            return ['status'=>false,'msg'=>'暂无此数据','data'=>10007];
        }

        $result = $this->isUpdate(true)->save($param, [$this->getPk() => $id]);
        if (!$result) {
            return ['status'=>false,'msg'=>'更新失败','data'=>10000];
        }
        return ['status'=>true,'msg'=>'操作成功','data'=>$result];
    }

    /**
     * 批量启用、禁用
     * @param  string  $ids    [主键数组]
     * @param  integer $status [状态1启用0禁用]
     * @param  boolean $delSon [是否删除子级数据] [预留暂不建议使用]
     * @return array   $result 处理结果
     */
    public function enableDatas(array $ids = [], int $status = 1, bool $delSon = false) : array
    {
        if (empty($ids)) {
            return ['status'=>false,'msg'=>'参数丢失','data'=>10003];
        }

        // 查找所有子元素
        if ($delSon && $status === '0') {
            foreach ($ids as $k => $v) {
                $childIds = $this->getAllChild($v);
                $ids = array_merge($ids, $childIds);
            }
            $ids = array_unique($ids);
        }
        try {
            $this->where($this->getPk(),'in',$ids)->setField('status', $status);
        } catch (\Exception $e) {
            return ['status'=>false,'msg'=>'操作失败','data'=>10000];
        }
        return ['status'=>true,'msg'=>'操作成功','data'=>200];
    }

    /**
     * 获取所有子级数据
     * @param  int   $id
     * @param  array $data
     * @return array $result 处理结果
     */
    public function getAllChild(int $id, array &$data = []) : array
    {
        $map['pid'] = $id;
        $childIds = $this->where($map)->column($this->getPk());
        if (!empty($childIds)) {
            foreach ($childIds as $v) {
                $data[] = $v;
                $this->getAllChild($v, $data);
            }
        }
        return $data;
    }
}