<?php
namespace app\manage\model;

use think\Model;

class UserRechargeModel extends Model{
	//表名
	protected $table = 'ly_user_recharge';

	/**
	 * 充值记录
	 */
	public function rechargeList(){
		$param = input('get.');
		//查询条件组装
		$where = array();
		//分页参数组装
		$pageParam = array();

		//用户名搜索
		if(isset($param['username']) && $param['username']){
			$uid = model('Merchant')->where('username', trim($param['username']))->value('id');
			$where[] = array('uid','=',$uid);
			$pageParam['username'] = $param['username'];
		}
		//订单号搜索
		if(isset($param['order_number']) && $param['order_number']){
			$where[] = array('order_number','=',trim($param['order_number']));
			$pageParam['order_number'] = $param['order_number'];
		}
		//状态搜索
		if(isset($param['state']) && $param['state']){
			$where[] = array('state','=',$param['state']);
			$pageParam['state'] = $param['state'];
		}
		// 时间
		if(isset($param['datetime_range']) && $param['datetime_range']){
			$dateTime = explode(' - ', $param['datetime_range']);
			$where[] = array('add_time','>=',strtotime($dateTime[0]));
			$where[] = array('add_time','<=',strtotime($dateTime[1]));
			$pageParam['datetime_range'] = $param['datetime_range'];
		}else{
			$todayStart = mktime(0,0,0,date('m'),date('d'),date('Y'));
			$where[] = array('add_time','>=',$todayStart);
			$todayEnd = mktime(23,59,59,date('m'),date('d'),date('Y'));
			$where[] = array('add_time','<=',$todayEnd);
		}

		//查询符合条件的数据
		// $resultData = $this->field('ly_user_recharge.*,users.username,recaivables.name,account,bank')->join('Recaivables','ly_user_recharge.actualamount = recaivables.id')->join('users','ly_user_recharge.uid = users.id')->where($where)->order('ly_user_recharge.add_time','desc')->paginate(15,false,['query'=>$pageParam]);
		$resultData = $this->field('ly_user_recharge.*,users.username')->join('users','ly_user_recharge.uid = users.id')->where($where)->order('ly_user_recharge.add_time','desc')->paginate(15,false,['query'=>$pageParam]);

		$stateColor = config('manage.color');
		$pageTotal['countMoney'] = 0;
		foreach ($resultData as $key => &$value) {
			// 状态颜色
			$value['stateColor'] = $stateColor[$value['state']];
			//分页统计
			$pageTotal['countMoney'] += $value['amount'];
		}

		//权限查询
		$powerWhere = [
			['uid','=',session('manage_userid')],
			['cid','=',3],
		];
		$power = model('ManageUserRole')->getUserPower($powerWhere);

		return array(
			'data'			=>	$resultData->toArray()['data'],
			'page'			=>	$resultData->render(),//分页
			'pageTotal'		=>	$pageTotal,
			'where'			=>	$pageParam,
			'power'			=>	$power,
		);
	}

	/**
	 * 充值订单审核view
	 */
	public function rechargeDisposeView(){
		$param = input('get.');

		$data = $this->field('ly_user_recharge.*,rechange_type.name')->join('rechange_type','ly_user_recharge.type=rechange_type.id')->where('ly_user_recharge.id',$param['id'])->find();
		// ->join('recaivables','ly_user_recharge.rid=recaivables.id','left')
		
		if ($data['daozhang_money'] <= 0) {
		    $data['daozhang_money'] = $data['money'];
		}
		
		return array(
			'data'	=>	$data
		);
	}

	/**
	 * 充值订单处理
	 */
    public function rechargeDispose($callback_order=[]){
	    //todo 事务、锁、队列等优化处理
        $param = [];
        if(!empty($callback_order)){
            $param['order_number'] = $callback_order['order_number'];
            $param['money'] = $callback_order['money'];
            $param['daozhang_money'] = $callback_order['daozhang_money'];
            $param['state'] = 1;
            $param['remarks'] = $callback_order['remarks'];
        }else{
            $param = input('post.');
        }
		if(!$param) return '提交失败';

		$controlAuditTime = cache('CA_rechargeDisposeTime'.session('manage_userid')) ? cache('CA_rechargeDisposeTime'.session('manage_userid')) : time()-2;
		if(time() - $controlAuditTime < 2){
			return ' 2 秒内不能重复提交';
		}
		cache('CA_rechargeDisposeTime'.session('manage_userid'), time(), 10);

		$orderNumber = $param['order_number'];
		unset($param['order_number']);
		$param['aid'] = session('manage_userid');
		$param['dispose_time'] = time();
		$res = $this->where(array(['order_number','=',$orderNumber],['state','=',3]))->update($param);
		if(!$res) return '操作失败1';

		if($param['state'] == 1){

			//获取订单信息
			$orderInfo = $this->field('uid,money,order_number')->where('order_number',$orderNumber)->find();

            if ($param['daozhang_money']) {
                $orderInfo['money'] = $param['daozhang_money'];
            }
			//获取用户余额
			$balance = model('UserTotal')->field('balance')->where('uid',$orderInfo['uid'])->find();
			//更新用户金额信息
			$res2 = model('UserTotal')->where('uid',$orderInfo['uid'])->inc('total_recharge',$orderInfo['money'])->inc('balance',$orderInfo['money'])->update();

            $this->upAllUpVip($orderInfo['uid']);

			if(!$res2) return '操作失败2';

			$tradeDetailsArray = array(
				'uid'					=>	$orderInfo['uid'],
				'order_number'			=>	$orderInfo['order_number'],
				'trade_type'			=>	1,
				'trade_before_balance'	=>	$balance['balance'],
				'trade_amount'			=>	$orderInfo['money'],
				'account_balance'		=>	$balance['balance'] + $orderInfo['money'],
				'remarks'				=>	'订单 '.$orderInfo['order_number'].' 充值成功，充值资金：'.$orderInfo['money'] . ', 到账金额：'.$param['daozhang_money'],
				'isadmin'				=>	1,
			);
			$res3 = model('common/TradeDetails')->tradeDetails($tradeDetailsArray);
			if(!$res3) return '操作失败3';
		}

		//添加操作日志
		model('Actionlog')->actionLog(session('manage_username'),'处理订单号为'.$orderNumber.'的充值订单',1);

		return 1;
	}

	//自动升级所有上级VIP
    //更新vip会员
    /*
     * V1会员。200起，不需要有下级会员，每天可以得到50个点赞。可以赚取到10到15卢比之间 。佣金比例%0.25
     * V2会员。2000起 需要3个1级会员 每天可以得到55个点赞。赚取120到130之间佣金比例%0.28
     * V3会员。5000起 需要5个2级会员。10个1级会员。每天60次订单。赚取400到450佣金比例%0.3
     * V4会员。10000起，需要10个3级会员。20个2级会员。30个1级会员，每天65次点赞赚取900到950 。佣金比例%0.32
     * V5会员。20000起 需要15个3级会员。30个20级会员。50个1级会员。每天70次点赞赚取1400到1500  佣金比例%0.36
     * V6会员。50000起.需要30个3级会员。50个2级会员。100个1级会员。每天80次订单赚取4500到5000   佣金比例%0.4
     * */
	public function upAllUpVip($uid)
    {
        //要判断的当前用户及所有上级
        $allUpUsers = $this->getAllUpVip($uid);
        $allSubMembers = $this->getSubMembers($allUpUsers);
//        var_dump($allUpUsers);exit;
        foreach ($allUpUsers as $item_uid){
            $balance = model('UserTotal')->field('balance')->where('uid',$item_uid)->find();
            $is_grade = model('UserVip')->where('uid',$item_uid)->field('grade')->find();
            $username = model('Users')->where('id',$item_uid)->where('user_type','>',1)->value('username');
            $updateData = [
                'uid' => $item_uid,
                'username' => $username,
                'state' => 1,
                'en_name' => 'Ordinary member',
                'name' => '普通会员',
                'ft_name' => 'Teradata',
                'ry_name' => 'Teradata',
                'ydn_name' => 'Teradata',
                'xby_name' => 'Teradata',
                'yn_name' => 'Teradata',
                'ty_name' => 'Teradata',
                'yd_name' => 'साधारण सदस्य',
                'grade' => 2,
                'stime' => time(),
                'etime' => time()+3600*24*800,
            ];
            //var_dump($updateData);
            if(!$is_grade){
                $rid = model('UserVip')->insert($updateData);
                //更新会员等级
                model('Users')->where('id', $uid)->update(array('vip_level'=>$updateData['grade']));
            }
            if ($balance['balance']>=200){
                model('UserVip')->where('uid',$item_uid)->update(['grade'=>$updateData['grade']+1,'name'=>50]);
            }elseif ( //v2
                $balance['balance']>=2000
                && $allSubMembers[$item_uid]['one']>=3
            ){
                model('UserVip')->where('uid',$item_uid)->update(['grade'=>$updateData['grade']+2,'name'=>55]);
            }elseif (  //v3
                $balance['balance']>=5000
                && $allSubMembers[$item_uid]['one']>=10
                && $allSubMembers[$item_uid]['two']>=5){
                model('UserVip')->where('uid',$item_uid)->update(['grade'=>$updateData['grade']+3,'name'=>60]);
            }elseif ( //v4
                $balance['balance']>=10000
                && $allSubMembers[$item_uid]['one']>=30
                && $allSubMembers[$item_uid]['two']>=20
                && $allSubMembers[$item_uid]['three']>=10){
                model('UserVip')->where('uid',$item_uid)->update(['grade'=>$updateData['grade']+4,'name'=>65]);
            }elseif ( //v5
                $balance['balance']>=20000 && $balance['balance']<50000
                && $allSubMembers[$item_uid]['one']>=50
                && $allSubMembers[$item_uid]['two']>=30
                && $allSubMembers[$item_uid]['three']>=15){
                model('UserVip')->where('uid',$item_uid)->update(['grade'=>$updateData['grade']+5,'name'=>70]);
            }elseif ( //v6
                $balance['balance']>=50000
                && $allSubMembers[$item_uid]['one']>=100
                && $allSubMembers[$item_uid]['two']>=50
                && $allSubMembers[$item_uid]['three']>=30){
                model('UserVip')->where('uid',$item_uid)->update(['grade'=>$updateData['grade']+6,'name'=>75]);
            }
        }
    }

	//获取当前及所有上级的用户
	public function getAllUpVip($uid)
    {
        $svip = model('Users')->where('id',$uid)->where('user_type','>',1)->field('sid')->find();
        $sid = !$svip ? 0 : $svip['sid'];
        if(!isset($upVipUsers)){
            $upVipUsers = [$uid];
        }
        if($sid>0){
            array_push($upVipUsers,$sid);
            $this->getAllUpVip($sid);
        }
        return $upVipUsers;
    }

    //获取会员的1，2，3级会员数量, [user1=>[one=>num,two=>num,three=>num],user2=>[one=>num,two=>num,three=>num]...]
    public function getSubMembers($uids=[])
    {
        $upVipSubMembers = [];
        foreach ($uids as $uid){
            //一级
            $upVipSubMembers[$uid]['one'] = 0;
            $tmp_one = model('Users')->where('sid',$uid)->field('uid')->select()->toArray();
            empty($tmp_one) ? : $upVipSubMembers[$uid]['one'] = count($tmp_one);
            //二级
            $upVipSubMembers[$uid]['two'] = 0;
            if($upVipSubMembers[$uid]['one']>0){
                $one_users = array_column($tmp_one,'uid');
                $tmp_two = model('Users')->where('sid','in',$one_users)->field('uid')->select()->toArray();
                $upVipSubMembers[$uid]['two'] = count($tmp_two);
            }
            //三级
            $upVipSubMembers[$uid]['three'] = 0;
            if($upVipSubMembers[$uid]['two']>0){
                $two_users = array_column($tmp_two,'uid');
                $tmp_three = model('Users')->where('sid','in',$two_users)->field('uid')->select()->toArray();
                $upVipSubMembers[$uid]['three'] = count($tmp_three);
            }
        }
        return $upVipSubMembers;
    }
}