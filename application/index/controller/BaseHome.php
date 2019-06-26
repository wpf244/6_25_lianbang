<?php
namespace app\index\controller;

use think\Controller;

class BaseHome extends Controller
{
    public function _initialize(){
        if (!defined('CONTROLLER_NAME')) {
            define('CONTROLLER_NAME', $this->request->controller());
        }
        if (!defined('ACTION_NAME')) {
            define('ACTION_NAME', $this->request->action());
        }
      
        $sys=db('sys')->where("id=1")->find();
        $this->assign("sys",$sys);

        $seo=db('seo')->where("id=1")->find();
        $this->assign("seo",$seo);

        
    }
}