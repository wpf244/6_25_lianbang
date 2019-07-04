<?php
namespace app\index\controller;

class Index extends BaseHome
{
    public function index()
    {
        $lb1=db("first")->where("fid",1)->find();

        $this->assign("lb1",$lb1);

        $lb2=db("first")->where("fid",2)->order(["sort asc","id desc"])->limit(4)->select();

        $this->assign("lb2",$lb2);

        $lb3=db("first")->where("fid",3)->find();

        $this->assign("lb3",$lb3);

        $lb4=db("trans")->where(["fid"=>2])->order(["sort asc","id desc"])->limit(8)->select();

        $this->assign("lb4",$lb4);

        $lb5=db("first")->where("fid",4)->find();

        $this->assign("lb5",$lb5);

        //配音案例

        $cases=db("dub_cases")->where("recome",1)->order(['sort asc','id desc'])->limit(5)->select();

        $this->assign("cases",$cases);

        //智能在线配音

        $lb6=db("lb")->where("fid",23)->find();

        $this->assign("lb6",$lb6);

        $lb7=db("lb")->where(["fid"=>24,"status"=>1])->order(["sort asc","id asc"])->limit(3)->select();

        $this->assign("lb7",$lb7);

        //真人主播配音
        $lb8=db("lb")->where("fid",25)->find();

        $this->assign("lb8",$lb8);

        $lb9=db("lb")->where(["fid"=>26,"status"=>1])->order(["sort asc","id asc"])->limit(3)->select();

        $this->assign("lb9",$lb9);

        //配音优势

        $lb10=db("lb")->where(["fid"=>27,"status"=>1])->order(["sort asc","id asc"])->limit(4)->select();

        $this->assign("lb10",$lb10);

        //服务中心
        $lb11=db("lb")->where(["fid"=>28,"status"=>1])->order(["sort asc","id asc"])->limit(3)->select();

        $this->assign("lb11",$lb11);

        //劳务输出
        $lb12=db("lb")->where("fid",29)->find();

        $this->assign("lb12",$lb12);

        //助力品牌
        $re=db("first")->where("fid",5)->find();

        $this->assign("re",$re);

        //成功案例
        $pass_cases=db("cases")->where(["status"=>1,"recome"=>1])->order(["sort asc","id desc"])->limit(8)->select();

        $this->assign("pass_cases",$pass_cases);

        //新闻中心

        $news=db("news")->where(["status"=>1,"groom"=>1])->order(["sort asc","id desc"])->select();

        $this->assign("news",$news);
        
        return $this->fetch();
    }
}
