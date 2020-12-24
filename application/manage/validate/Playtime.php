<?php

namespace app\manage\validate;

use think\Validate;

class Playtime extends Validate
{
	protected $rule =   [
        'no'			=> 'require|alphaNum',
		'startime'		=> 'require|dateFormat:Y-m-d H:i:s|lt:endtime',
		'endtime'		=> 'require|dateFormat:Y-m-d H:i:s|gt:startime',
		'closetime'		=> 'require|integer',
    ];
    
    protected $message  =   [
        'no.require'            =>  '请填写期号',
        'no.alphaNum'           =>  '期号格式不正确',
        'startime.require'      =>  '请填写开始时间',
        'startime.dateFormat'   =>  '开始时间格式不正确',
        'startime.lt'           =>  '开始时间应小于结束时间',
        'endtime.require'       =>  '请填写结束时间',
        'endtime.dateFormat'    =>  '结束时间格式不正确',
        'endtime.gt'            =>  '结束时间应大于开始时间',
        'closetime.require'     =>  '请填写封单时间',
        'closetime.integer'     =>  '封单时间格式不正确',
    ];

    protected $scene = [
        'createTime'       =>  ['no','startime','endtime','closetime'],
    ];
}
