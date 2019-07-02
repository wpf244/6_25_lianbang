<?php
namespace app\index\controller;

class Call extends BaseHome
{
    public function index()
    {
        $lb=db("lb")->where(["fid"=>21,"status"=>1])->order(["sort asc","id asc"])->limit(3)->select();

        $this->assign("lb",$lb);

        $lbg=db("lb")->where(["fid"=>22,"status"=>1])->order(["sort asc","id asc"])->select();

        $this->assign("lbg",$lbg);
        
        return $this->fetch();
    }
    public function map()
    {
        return $this->fetch();
    }
}