<?php
namespace app\api\controller;

use app\api\controller\BaseController;

class TransactionController extends BaseController{

	/**
	 * 提现
	 */
	public function draw(){
		$data = model('UserWithdrawals')->draw();
		return json($data);
	}


	/**
	 * 提现记录
	 */
	public function getDrawRecord(){
		$data = model('UserWithdrawals')->getUserWithdrawalsList();
		return json($data);
	}
	
	/**
	 * 渠道充值
	 */
	public function getRechargetype(){
		$data = model('RechangeType')->getRechargetype();
		return json($data);
	}

	/**
	 * 充值记录
	 */
	public function getRechargeRecord(){
		$data = model('UserRecharge')->getUserRechargeList();
		return json($data);
	}

	//资金明显 流水
	public function FundDetails(){
		$data = model('UserTransaction')->FundDetails();
		return json($data);
	}
	//转账
	public function Transfer(){
		$data = model('UserTransaction')->Transfer();
		return json($data);
	}
	
}