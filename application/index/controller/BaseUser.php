<?php
namespace app\index\controller;

use think\Controller;

class BaseUser extends Controller
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

        $pc_banner=db("lb")->where(["fid"=>1,"status"=>1])->order(["sort asc","id desc"])->select();

        $this->assign("pc_banner",$pc_banner);

        $m_banner=db("lb")->where(["fid"=>2,"status"=>1])->order(["sort asc","id desc"])->select();

        $this->assign("m_banner",$m_banner);

        $uid=session("userid");

        $this->assign("uid",$uid);

        if($uid){
            $user=db("user")->where("uid",$uid)->find();

            $this->assign("user",$user);
        }else{
            $this->redirect("Login/login");
        }

        //友情链接
        $link=db("lb")->where(["fid"=>3,"status"=>1])->order(["sort asc","id desc"])->select();

        $this->assign("link",$link);

        
    }
}