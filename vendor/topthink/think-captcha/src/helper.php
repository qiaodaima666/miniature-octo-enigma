<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2015 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: yunwuxin <448901948@qq.com>
// +----------------------------------------------------------------------

use think\captcha\Captcha;
use think\Config;
use think\Response;
use think\Route;
use think\Url;
use think\Validate;

Route::get('captcha/[:id]', "\\think\\captcha\\CaptchaController@index");

Validate::extend('captcha', function ($value, $id = "") {
    return captcha_check($value, $id, (array)Config::get('captcha'));
});

Validate::setTypeMsg('captcha', '验证码错误!');


/**
 * @param string $id
 * @param array  $config
 * @return Response
 */
function captcha($id = "", $config = [])
{
    $captcha = new Captcha($config);
    return $captcha->entry($id);
}


/**
 * @param $id
 * @return string
 */
function captcha_src($id = "")
{
    return Url::build('/captcha' . ($id ? "/{$id}" : ''));
}


/**
 * @param $id
 * @return mixed
 */
function captcha_img($id = "")
{
    return '<img src="' . captcha_src($id) . '" alt="captcha" />';
}


/**
 * @param        $value
 * @param string $id
 * @param array  $config
 * @return bool
 */
function captcha_check($value, $id = "", $config = [])
{
    $captcha = new Captcha($config);
    return $captcha->check($value, $id);
}

