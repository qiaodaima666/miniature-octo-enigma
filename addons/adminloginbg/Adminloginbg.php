<?php

namespace addons\adminloginbg;

use think\Addons;
use think\Request;
use think\View;

/**
 * 登录背景图插件
 */
class Adminloginbg extends Addons
{

    /**
     * 插件安装方法
     * @return bool
     */
    public function install()
    {
        return true;
    }

    /**
     * 插件卸载方法
     * @return bool
     */
    public function uninstall()
    {
        return true;
    }

    public function adminLoginInit(Request &$request)
    {
        $info = $this->getInfo();
        if($info['state'] ==1) {
            $config = $this->getConfig();
            if ($config['mode'] == 'random' || $config['mode'] == 'daily') {
                $index = $config['mode'] == 'random' ? mt_rand(1, 4000) : date("Ymd") % 4000;
                $background = "http://img.infinitynewtab.com/wallpaper/" . $index . ".jpg";
            } else {
                $background = $config['image'];
            }
            View::instance()->assign('background', $background);
        }
    }

}
