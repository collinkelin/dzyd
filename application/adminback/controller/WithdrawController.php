<?php
namespace app\admin\controller;

use app\admin\controller\Common;

class WithdrawController extends CommonController{
	/**
	 * 空操作处理
	 */
	public function _empty(){
		return $this->index();
	}
	/**
	 * 订单明细
	 * @return [type] [description]
	 */
	public function index(){
		$data = model('MerchantWithdrawals')->index();

		return view('', [
			'where'          =>	$data['where'],
			'data'           =>	$data['data'],
			'page'           =>	$data['page'],
			'balance'        =>	$data['balance'],
			'bankList'       =>	$data['bankList'],
			'withdrawStatus' =>	$data['withdrawStatus'],
		]);
	}

	/**
	 * 商户提现
	 * @return [type] [description]
	 */
	public function withdrawSub(){
		return model('MerchantWithdrawals')->withdrawSub();
	}
}