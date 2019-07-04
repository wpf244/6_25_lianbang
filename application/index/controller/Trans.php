<?php
namespace app\index\controller;

class Trans extends BaseHome
{
    public function index()
    {
        $lb1=db("trans")->where("fid",1)->find();

        $this->assign("lb1",$lb1);

        $lb2=db("trans")->where(["fid"=>2])->order(["sort asc","id desc"])->limit(8)->select();

        $this->assign("lb2",$lb2);

        $lb3=db("trans")->where("fid",3)->find();

        $this->assign("lb3",$lb3);

        $lb4=db("trans")->where(["fid"=>4])->order(["sort asc","id desc"])->select();

        $this->assign("lb4",$lb4);

        $lb5=db("trans")->where("fid",5)->find();

        $this->assign("lb5",$lb5);

        $lb6=db("trans")->where("fid",6)->find();

        $this->assign("lb6",$lb6);

        $lb7=db("trans")->where(["fid"=>7])->order(["sort asc","id desc"])->select();

        $this->assign("lb7",$lb7);

        $lb8=db("trans")->where("fid",8)->find();

        $this->assign("lb8",$lb8);
        
        return $this->fetch();
    }
}