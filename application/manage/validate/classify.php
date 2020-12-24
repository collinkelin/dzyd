<?php

namespace app\manage\validate;

use think\Validate;

class classify extends Validate
{
	protected $rule =   [
        'class'  => 'require',
		'class'  => 'alphaNum',
		'class_name'   => 'require',
    ];
    
    protected $message  =   [
        'class.require'	    => '分类必须',
        'class.alphaNum'     => '分类不正确',
		'role_url.require'	=> '分类必须',
    ];
}
