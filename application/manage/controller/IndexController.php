<?php
namespace app\manage\controller;

use think\Controller;

class IndexController extends Controller{

	public function initialize(){
    	header('Access-Control-Allow-Origin:*');    	
	}
	
    public function index(){
		// 是否登录
		$is_admin_login = session('is_manage_login');
		// 获取标题
		$setting = model('Setting')->getFieldsById('manage_title');
		
		if($is_admin_login){
			//获取用户权限
			$adminRole = model('ManageUserRole')->getAdminsRoleByUsersId(session('manage_userid'));

        $yes1 = strtotime( date("Y-m-d 00:00:00",strtotime("-1 day")) );
        $yes2 = strtotime( date("Y-m-d 23:59:59",strtotime("-1 day")) );	
        //用户
        $userzong = model('Users')->count(); 
        $usertoday = model('Users')->where('reg_time','between',[strtotime(date('Y-m-d')),time()])->count(); 
        $userzt = model('Users')->where('reg_time','between',[$yes1,$yes2])->count(); 
        //购买VIP
        $vipzong = model('trade_details')->where(array(['trade_type','=',9]))->count(); 
        $viptoday = model('trade_details')->where(array(['trade_type','=',9]))->where('trade_time','between',[strtotime(date('Y-m-d')),time()])->count();
        $vipzt = model('trade_details')->where(array(['trade_type','=',9]))->where('trade_time','between',[$yes1,$yes2])->count();
        //下单
        $xiadzong = model('user_task')->count(); 
        $xiadtoday = model('user_task')->where('add_time','between',[strtotime(date('Y-m-d')),time()])->count(); 
        $xiadzt = model('user_task')->where('add_time','between',[$yes1,$yes2])->count(); 
        //充值人
        $czzong = model('user_recharge')->where(array(['state','=',1]))->count(); 
        $cztoday = model('user_recharge')->where(array(['state','=',1]))->where('add_time','between',[strtotime(date('Y-m-d')),time()])->count();
        $czzt = model('user_recharge')->where(array(['state','=',1]))->where('add_time','between',[$yes1,$yes2])->count();
        //充值总额
        $czzonge = model('user_recharge')->where(array(['state','=',1]))->sum('money'); 
        $cztodaye = model('user_recharge')->where(array(['state','=',1]))->where('add_time','between',[strtotime(date('Y-m-d')),time()])->sum('money');
        $czzte = model('user_recharge')->where(array(['state','=',1]))->where('add_time','between',[$yes1,$yes2])->sum('money');
        //提现人
        $txzong = model('user_withdrawals')->where(array(['state','=',1]))->count(); 
        $txtoday = model('user_withdrawals')->where(array(['state','=',1]))->where('time','between',[strtotime(date('Y-m-d')),time()])->count();
        $txzt = model('user_withdrawals')->where(array(['state','=',1]))->where('time','between',[$yes1,$yes2])->count();
        //提现总额
        $txzonge = model('user_withdrawals')->where(array(['state','=',1]))->sum('price'); 
        $txtodaye = model('user_withdrawals')->where(array(['state','=',1]))->where('time','between',[strtotime(date('Y-m-d')),time()])->sum('price');
        $txzte = model('user_withdrawals')->where(array(['state','=',1]))->where('time','between',[$yes1,$yes2])->sum('price');
        
        //用户余额
        $userzonge = model('user_total')->sum('balance'); 

			return view('index', [
				'title'          => $setting['manage_title'],
				'admin_username' => session('manage_username'),
				'admin_userid'   => session('manage_userid'),
				'adminRole'      => $adminRole,
				'userzong'      => $userzong,
				'usertoday'      => $usertoday,
				'userzt'      => $userzt,
				'vipzong'      => $vipzong,
				'viptoday'      => $viptoday,
				'vipzt'      => $vipzt,
				'xiadzong'      => $xiadzong,
				'xiadtoday'      => $xiadtoday,
				'xiadzt'      => $xiadzt,
				'czzong'      => $czzong,
				'cztoday'      => $cztoday,
				'czzt'      => $czzt,
				'czzonge'      => $czzonge,
				'cztodaye'      => $cztodaye,
				'czzte'      => $czzte,
				
				'txzong'      => $txzong,
				'txtoday'      => $txtoday,
				'txzt'      => $txzt,
				'txzonge'      => $txzonge,
				'txtodaye'      => $txtodaye,
				'txzte'      => $txzte,
				'userzonge'      => $userzonge,
			]);
		}

		return view('login', [
			'title' => $setting['manage_title']
		]);
	
	//昨天

		
		
	}
	
	//登录提交
	public function login(){

		//是否是isAjax提交		
		if ($this->request->isAjax()) {
			// 登录验证
			return model('Manage')->checkLogin();
		}
		
		
		return 'nouser';
		
	}
	
	//验证码
	public function code(){

		ob_clean();
		
		$image = imagecreatetruecolor(100, 34);  
		$bgcolor = imagecolorallocate($image, 255, 255, 255);  
		imagefill($image, 0, 0, $bgcolor);  
	  
		$captch_code = '';  
		for($i=0;$i<4;$i++) { 
		 
			$fontsize = 6;  
			$fontcolor = imagecolorallocate($image, rand(0, 120), rand(0, 120),rand(0, 120));  
	  
			$data = '0123456789';  
			$fontcontent = substr($data, rand(0, strlen($data)-1), 1);
			$captch_code .= $fontcontent;  
	  
			$x = ($i*100/4) + rand(5, 10);  
			$y = rand(5, 10);  
	  
			imagestring($image, $fontsize, $x, $y, $fontcontent, $fontcolor);  
		}
		session('code',$captch_code);  
	  
		//增加点干扰元素  
		for($i=0; $i<200;$i++) {  
			$pointcolor = imagecolorallocate($image, rand(50,200), rand(50,200), rand(50,200));  
			imagesetpixel($image, rand(1,99), rand(1,29), $pointcolor);  
		}  
	  
		//增加线干扰元素  
		for($i=0;$i<3;$i++) {  
			$linecolor = imagecolorallocate($image, rand(80,220), rand(80,220), rand(80, 220));  
			imageline($image, rand(1,99), rand(1,29), rand(1,99), rand(1,29), $linecolor);  
		}  
	  
	  
		header('content-type:image/png');  
		imagepng($image);  
	  
		imagedestroy($image);  
	}
	//退出
	public function logout(){
		//删除session 包括用户登录数据 ，添加文章数据
		session('is_manage_login', null);
		session('manage_username', null);
		session('manage_userid', null);
		return 1;
		
	}
	public function home(){
		//获取标题
		$Setting = model('Setting')->getFieldsById('manage_title');
		
		$this->assign('title',$Setting['manage_title']);

		$this->assign('admin_username',session('manage_username'));
		
		$this->assign('admin_userid',session('manage_userid'));
		
		return $this->fetch('home');
	}

}
