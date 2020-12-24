<?php

namespace app\manage\validate;

use think\Validate;

class role extends Validate
{
	protected $rule =   [
        'role_name'  => 'require',
		'role_name'  => 'chsAlphaNum',
		'role_url'   => 'require',
        'role_url'   => 'regex:^[a-zA-Z\/_]+$',
    ];
    
    protected $message  =   [
        'role_name.require'	    => '权限名必须',
        'role_name.chsAlphaNum'     => '权限名必须中文',
		'role_url.require'	=> '权限必须',
		'role_url.regex'	=> '权限不正确',
    ];
}
