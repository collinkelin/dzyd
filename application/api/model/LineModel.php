<?php
namespace app\api\model;

use think\Model;

class LineModel extends Model{
	/**
	 * [getNotice 获取线路数组]
	 * @return [type] [description]
	 */
	public function getLineArray(){
		$data	= json_encode(['http://103.101.207.193:8090','http://103.101.207.193:8090','http://103.101.207.193:8090','http://103.101.207.193:8090','http://103.101.207.193:8090']);		
		
		return $data;
	}
	
	
}