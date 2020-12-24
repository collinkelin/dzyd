<?php

namespace app\manage\validate;

use think\Validate;

class play extends Validate
{
	protected $rule =   [
		'class'   	 => 'require|alphaNum',
        //'game_name'  => 'require|chsAlphaNum',
		'name'   	 => 'require|alphaNum',
		'types'   	 => 'require|alpha',
		'isopen'   	 => 'require|number',
    ];
    
    protected $message  =   [
    	'class.require'	    	=> '彩种类型必须',
    	'class.alphaNum'		=> '彩种类型只能为字母和数字',
        'game_name.require'	    => '游戏名必须',
        'game_name.chsAlphaNum'	=> '游戏名只能是汉字、字母和数字',
		'name.require'			=> '游戏必须',
		'name.alphaNum'			=> '游戏只能字母和数字',
		'types.require'			=> '玩法类型必须',
		'types.alpha'			=> '玩法类型只能为纯字母',
		'isopen.require'		=> '玩法是否开奖必须',
		'isopen.number'			=> '玩法类型只能为纯数字',
    ];

    protected $scene = [
        'add'       =>  ['class','game_name','name','types','isopen'],
        'edit'      =>  ['class','game_name','name','types','isopen'],
    ];
}
