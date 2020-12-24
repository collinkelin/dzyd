<?php

namespace app\manage\validate;

use think\Validate;

class Bet extends Validate
{
    protected $rule =   [
        'lottery'         =>  'require|alphaNum',
        'no'              =>  'require|number',
    ];

    protected $message =   [
        'lottery.require'           =>  '彩种不能为空',
        'lottery.alphaNum'          =>  '彩种格式不正确',
        'no.require'                =>  '期号不能为空',
        'no.number'                 =>  '期号格式不正确',
    ];

    protected $scene = [
        'cancelMany'           =>  ['lottery','no'],
    ];
}