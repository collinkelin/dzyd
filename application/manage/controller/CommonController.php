<?php
namespace app\manage\controller;

use think\Controller;

class CommonController extends Controller{
	//ThinkPHP构造函数
    public function initialize(){

    	header('Access-Control-Allow-Origin:*');

		ini_set ('session.cookie_lifetime',86400);

		ini_set ('session.gc_maxlifetime',86400);
		
		//判断是否登陆
		$is_admin_login = session('is_manage_login');

		if(!isset($is_admin_login) || empty($is_admin_login)) {
			if (request()->isAjax()) {
				return '未登录！';
			} else {
				return $this->success('未登录！', '/manage/index');
			}
		}

		// 检查IP
		// $isIpWhite = model('Setting')->where('id','>',0)->value('manage_ip_white');
		// if ($isIpWhite == 2) {
		// 	$ip = request()->ip();
		// 	$ipList = model('IpWhite')->column('ip');
		// 	if (!in_array($ip, $ipList)) {
		// 		session('is_manage_login', null);
		// 		session('manage_username', null);
		// 		session('manage_userid', null);
		// 		echo '<script>alert("您的登录已过期或账号已在别处登录！");top.location.href="/manage/index"</script>';
		// 	}
		// }

		//判断权限
		$where_role = array(
			'uid'		=>	session('manage_userid'),//管理员
			'role_url'	=>	request()->controller().'/'.request()->action(),//获取控制器/方法
			'state'		=>	1,//管理员
		);
		$is_role =	model('ManageUserRole')->checkUsersRole($where_role);

		if(!$is_role){
			if (request()->isAjax()) {
				return '您没有权限操作！';
			} else {
				return $this->success('您没有权限操作！', '/manage/index');
			}			
		}
	}

	/*
	// 获取传输协议
	$isHttps = ((isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) == 'https')) ? 'https' : 'http';
	return $isHttps.'://'.$_SERVER['HTTP_HOST'];
	 */

    //获取代理所有团队用户ID
    public function getAllAgentUids(){
        $agent_info = model('Manage')->where('id',session('manage_userid'))->find();
        if($agent_info['type']==1){
            //获取所有自己及下级成员
            $agent_uid = model('Users')->where('username',$agent_info['username'])->value('id');//普通用户表对应的用户ID
            $allSub = model('UserTeam')->where('uid',$agent_uid)->column('team');
            return $allSub;
        }
        return [];
    }

    //获取区域代理所有团队用户ID
    public function getAreaAgentUids($aid=null)
    {
        if($aid){
            $agentUsers = model('Manage')->where('area_type',$aid)->column('username');
            $agentIds = [];
            foreach ($agentUsers as $item){
                $agentIds[] = model('Users')->where('username', $item)->value('id');
            }
            $teamUids = model('UserTeam')->where('uid','in',$agentIds)->column('team');
            return $teamUids;
        }
        return [];
    }

    public function getAreaList()
    {
        return [
            1 => '大区一',
            2 => '大区二',
            3 => '大区三',
            4 => '大区四',
            5 => '大区五',
            6 => '大区六',
            7 => '大区七',
            8 => '大区八',
            9 => '大区九',
            10 => '大区十',
        ];
    }
}
