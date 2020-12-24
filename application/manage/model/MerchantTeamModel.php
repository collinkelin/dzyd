<?php
namespace app\manage\model;

use think\Model;

class MerchantTeamModel extends Model{
	//表名
	protected $table = 'ly_merchant_team';

	/**
	 * 注册商户团队表
	 * @param  integer  $id 新注册商户ID
	 * @return bool        [description]
	 */
	public function reg($id){

		$above = $this->getAbove($id);
		foreach ($above as $key => $value) {
			$insertData[] = array('uid'=>$value, 'team'=>$id);
		}
		$result = $this->insertAll($insertData);

		if ($result != count($above)) return false;

		return true;
	}

	/**
	 * 获取商户所有上级
	 * @return [type] [description]
	 */
	public function getAbove($mid, $array=array()){
		$info = model('Merchant')->field('id,sid')->where('id', $mid)->find();
		$array[] = $info['id'];
		if ($info['sid']) $array = $this->getAbove($info['sid'],$array);

		return $array;
	}
}