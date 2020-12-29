<?php
namespace app\manage\controller;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use app\manage\controller\Common;

class AgentController extends CommonController{

    public function index(){
        // 是否登录
        $is_admin_login = session('is_manage_login');
        // 获取标题
        $setting = model('Setting')->getFieldsById('manage_title');

        if($is_admin_login){
//            $manage_info = model('Manage')->where('id',session('manage_userid'))->find();
            //获取所有自己及下级成员
            //获取参数
            $param = input('get.');
            $username = $param['name'];
            $agent_uid = model('Users')->where('username',$username)->value('id');//普通用户表对应的用户ID
            $teamUids = model('UserTeam')->where('team',$agent_uid)->column('uid');
//            var_dump($teamUids);exit;
                //获取用户权限
                $adminRole = model('ManageUserRole')->getAdminsRoleByUsersId(session('manage_userid'));

                $yes1 = strtotime( date("Y-m-d 00:00:00",strtotime("-1 day")) );
                $yes2 = strtotime( date("Y-m-d 23:59:59",strtotime("-1 day")) );
                //用户
                $userzong = model('Users')->where('id','in',$teamUids)->count();
                $usertoday = model('Users')->where('id','in',$teamUids)->where('reg_time','between',[strtotime(date('Y-m-d')),time()])->count();
                $userzt = model('Users')->where('id','in',$teamUids)->where('reg_time','between',[$yes1,$yes2])->count();
                //购买VIP
                $vipzong = model('trade_details')->where('uid','in',$teamUids)->where(array(['trade_type','=',9]))->count();
                $viptoday = model('trade_details')->where('uid','in',$teamUids)->where(array(['trade_type','=',9]))->where('trade_time','between',[strtotime(date('Y-m-d')),time()])->count();
                $vipzt = model('trade_details')->where('uid','in',$teamUids)->where(array(['trade_type','=',9]))->where('trade_time','between',[$yes1,$yes2])->count();
                //下单
                $xiadzong = model('user_task')->where('uid','in',$teamUids)->count();
                $xiadtoday = model('user_task')->where('uid','in',$teamUids)->where('add_time','between',[strtotime(date('Y-m-d')),time()])->count();
                $xiadzt = model('user_task')->where('uid','in',$teamUids)->where('add_time','between',[$yes1,$yes2])->count();
                //充值人
                $czzong = model('user_recharge')->where('uid','in',$teamUids)->where(array(['state','=',1]))->count();
                $cztoday = model('user_recharge')->where('uid','in',$teamUids)->where(array(['state','=',1]))->where('add_time','between',[strtotime(date('Y-m-d')),time()])->count();
                $czzt = model('user_recharge')->where('uid','in',$teamUids)->where(array(['state','=',1]))->where('add_time','between',[$yes1,$yes2])->count();
                //充值总额
                $czzonge = model('user_recharge')->where('uid','in',$teamUids)->where(array(['state','=',1]))->sum('money');
                $cztodaye = model('user_recharge')->where('uid','in',$teamUids)->where(array(['state','=',1]))->where('add_time','between',[strtotime(date('Y-m-d')),time()])->sum('money');
                $czzte = model('user_recharge')->where('uid','in',$teamUids)->where(array(['state','=',1]))->where('add_time','between',[$yes1,$yes2])->sum('money');
                //提现人
                $txzong = model('user_withdrawals')->where('uid','in',$teamUids)->where(array(['state','=',1]))->count();
                $txtoday = model('user_withdrawals')->where('uid','in',$teamUids)->where(array(['state','=',1]))->where('time','between',[strtotime(date('Y-m-d')),time()])->count();
                $txzt = model('user_withdrawals')->where('uid','in',$teamUids)->where(array(['state','=',1]))->where('time','between',[$yes1,$yes2])->count();
                //提现总额
                $txzonge = model('user_withdrawals')->where('uid','in',$teamUids)->where(array(['state','=',1]))->sum('price');
                $txtodaye = model('user_withdrawals')->where('uid','in',$teamUids)->where(array(['state','=',1]))->where('time','between',[strtotime(date('Y-m-d')),time()])->sum('price');
                $txzte = model('user_withdrawals')->where('uid','in',$teamUids)->where(array(['state','=',1]))->where('time','between',[$yes1,$yes2])->sum('price');

                //会员余额
                $userzonge = model('user_total')->where('uid','in',$teamUids)->sum('balance');

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

	/**
	 * 空操作处理
	 */
	public function _empty(){
		return $this->UserList();
	}
	/**
	 * 用户列表
	 */
	public function lists(){
		if (request()->isAjax()) {
			//获取参数
			$param = input('post.');
			//查询条件组装
            $where = [];
			$where[] = ['ly_users.user_type','=',1];
			//用户名
			if(isset($param['username']) && $param['username']){
				$where[] = ['ly_users.username','like','%'.$param['username'].'%'];
			}
			//用户名
			if(isset($param['uid']) && $param['uid']){
				$where[] = ['ly_users.uid','=',$param['uid']];
			}
			
			if (isset($param['user_type']) && $param['user_type']) {
			    $where[] = ['ly_users.user_type', '=', $param['user_type']];
			}

			//邀请码 推荐人
			if(isset($param['idcode']) && $param['idcode']){
				$where[] = ['ly_users.recommend','=',$param['idcode']];
			}

			//用户名
			if(isset($param['balance1']) && $param['balance1']){
				$where[] = ['user_total.balance','>=',$param['balance1']];
			}
			//用户名
			if(isset($param['balance2']) && $param['balance2']){
				$where[] = ['user_total.balance','<=',$param['balance2']];
			}
			//用户名
			if(isset($param['state']) && $param['state']){
				$where[] = ['ly_users.state','=',$param['state']];
			}
			//用户名
			if(isset($param['is_automatic']) && $param['is_automatic']){
				$where[] = ['ly_users.is_automatic','=',$param['is_automatic']];
			}
			// 时间
			if(isset($param['datetime_range']) && $param['datetime_range']){
				$dateTime = explode(' - ', $param['datetime_range']);
				$where[]  = ['reg_time','>=',strtotime($dateTime[0])];
				$where[]  = ['reg_time','<=',strtotime($dateTime[1])];
			}


            $count              = model('Users')->join('user_total','ly_users.id = user_total.uid')->where($where)->count(); // 总记录数
			$param['limit']     = (isset($param['limit']) and $param['limit']) ? $param['limit'] : 15; // 每页记录数
			$param['page']      = (isset($param['page']) and $param['page']) ? $param['page'] : 1; // 当前页
			$limitOffset        = ($param['page'] - 1) * $param['limit']; // 偏移量
			$param['sortField'] = (isset($param['sortField']) && $param['sortField']) ? $param['sortField'] : 'reg_time';
			$param['sortType']  = (isset($param['sortType']) && $param['sortType']) ? $param['sortType'] : 'desc';

			//查询符合条件的数据
			$data = model('Users')->field(['ly_users.*','user_total.balance','user_total.total_balance'])->join('user_total','ly_users.id = user_total.uid')->where($where)->order($param['sortField'], $param['sortType'])->limit($limitOffset, $param['limit'])->select()->toArray();

			$userState = config('custom.userState');//账号状态
			foreach ($data as $key => &$value) {
				$value['reg_time'] = date('Y-m-d H:i:s', $value['reg_time']);
				$value['stateStr']    = $userState[$value['state']];
				$value['isOnline'] = (cache('C_token_'.$value['id'])) ? '在线' : '离线';
			}
			return json([
				'code'  => 0,
				'msg'   => '',
				'count' => $count,
				'data'  => $data
			]);
		}

		return view();
	}

}