<?php

namespace app\admin\validate;

use think\Validate;

class Common extends Validate{
    protected $rule =   [
        'code'   =>  'require|number|integer',
    ];

    protected $message =   [
        'code.require' =>  '请输入验证码',
        'code.number'  =>  '验证码格式不正确',
        'code.integer' =>  '验证码格式不正确',
    ];

    protected $scene = [
        'checkSMSCode' =>  ['code'],
    ];
}