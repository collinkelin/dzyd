<?php
namespace app\api\controller;

use think\Controller;

class ActivityController extends Controller{
	//初始化方法
	protected function initialize(){		
	 	parent::initialize();		
		header('Access-Control-Allow-Origin:*');
		//header('Access-Control-Allow-Credentials: true');
		//header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
		//header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId");
    }
	

    /**  获取活动列表  **/
	public function getActivityList(){
		$data = model('Activity')->getActivityList();
		return json($data);
	}
	
	
	/**  获取用户活动记录列表  **/
	public function getUserActivityList(){
		$data = model('Activity')->getUserActivityList();
		return json($data);
	}
	
}
