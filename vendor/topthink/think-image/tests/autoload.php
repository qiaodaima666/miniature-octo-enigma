<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2015 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: yunwuxin <448901948@qq.com>
// +----------------------------------------------------------------------
use think\Loader;

define('TEST_PATH', __DIR__ . '/');
// 加载框架基础文件
require __DIR__ . '/../thinkphp/base.php';
Loader::addNamespace('tests', TEST_PATH);
Loader::addNamespace('think', __DIR__ . '/../src/');