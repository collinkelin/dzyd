<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// +----------------------------------------------------------------------
// | 支付相关配置
// +----------------------------------------------------------------------

return [
	'recharge_api'	=>	"http://paycollin.payto89.com/order/placeForIndex",
	'forward_api'	=>	"http://tcollin.payto89.com:82/order/cashout",
	'secret'	=>	"964326dc04404b8cb21051c7b3f63e38",
	'merchant_id'	=>	"213081465",
	'account'	=>	"collin",
	'notify_url'	=>	'http://'.$_SERVER['HTTP_HOST']."/api/Order/callBack",
	//代付相关
    'bank_name' => 'HDFC BANK',
    'bank_branch' => 'DICHPALLY BRANCH',
    'bank_account' => '50100377989344',
    'bank_username' => 'MIRZA AMEER BAIG',
    'bank_ifsc' => 'HDFC0003447',
    'bank_email' => 'collinkelin2021@gmail.com',
    'bank_tel' => '009198292134',
];