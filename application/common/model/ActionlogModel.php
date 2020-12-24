<?php

/**
 * 编写：祝踏岚
 * 作用：生成操作日志
 */

namespace app\common\model;

use think\Model;

class ActionlogModel extends Model{
	//表名
	protected $table = 'ly_actionlog';

	/**
	 * 添加操作日志
	 * @param string $username 操作用户名
	 * @param string $log 日志内容
	 * @param integer $isadmin 是否后台用户操作，后台传1
	 */
	public function actionLog($username,$log,$isadmin=2){
		$array = array(
			'username'	=>	$username,
			'time'		=>	time(),
			'ip'		=>	model('Loginlog')->getClientIp(),
			'log'		=>	$log,
			'isadmin'	=>	$isadmin,
		);
		//添加操作记录
		$this->save($array);
	}
}