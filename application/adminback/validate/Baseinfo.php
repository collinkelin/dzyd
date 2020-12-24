<?php

namespace app\admin\validate;

use think\Validate;

class Baseinfo extends Validate{
    protected $rule =   [
        'alipay_fee' =>  'regex:^\-?\d+\.?\d*$',
        'wechat_fee' =>  'regex:^\-?\d+\.?\d*$',
        'bank_fee'   =>  'regex:^\-?\d+\.?\d*$',
    ];

    protected $message =   [
        'alipay_fee.regex' =>  '请填写有效的费率',
        'wechat_fee.regex' =>  '请填写有效的费率',
        'bank_fee.regex'   =>  '请填写有效的费率',
    ];

    protected $scene = [
        'teamFeeEdit'    =>  ['alipay_fee','wechat_fee','bank_fee'],
    ];

    /**
     * 验证支付宝费率
     */
    protected function checkAlipayFee($value){
        $password = model('Merchant')->where('id', session('admin_userid'))->value('password');
        if (auth_code($password, 'DECODE') != $value) return '密码不正确';
        return true;
    }
}