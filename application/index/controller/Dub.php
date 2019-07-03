<?php
namespace app\index\controller;

class Dub extends BaseHome
{
    public function index()
    {
        $lb1=db("dub")->where("fid",1)->find();

        $this->assign("lb1",$lb1);

        $lb3=db("dub")->where("fid",3)->find();

        $this->assign("lb3",$lb3);

        $lb4=db("dub")->where("fid",4)->order(['sort asc','id desc'])->select();

        $this->assign("lb4",$lb4);

        $lb5=db("dub")->where("fid",5)->find();

        $this->assign("lb5",$lb5);


        //配音案例

        $cases=db("dub_cases")->where("recome",1)->order(['sort asc','id desc'])->limit(5)->select();

        $this->assign("cases",$cases);

        //筛选分类
        $langs=db("dub_type")->where("fids",1)->order(["tsort asc","tid desc"])->select();

        $this->assign("langs",$langs);

        $type=db("dub_type")->where("fids",2)->order(["tsort asc","tid desc"])->select();

        $this->assign("type",$type);

        $age=db("dub_type")->where("fids",3)->order(["tsort asc","tid desc"])->select();

        $this->assign("age",$age);

        $mood=db("dub_type")->where("fids",4)->order(["tsort asc","tid desc"])->select();

        $this->assign("mood",$mood);


        //特价专区
        $ret=db("dub")->where(["fid"=>2,"te"=>1])->order(["sort asc","id desc"])->limit(3)->select();

        foreach($ret as $k => $v){
            $ret[$k]['type']=$type;

            foreach($ret[$k]['type'] as $kt => $vt){
                $ret[$k]['type'][$kt]['list']=db("dub_video")->where(["did"=>$v['id'],"tid"=>$vt['tid']])->order(["sort asc","id desc"])->select();
            }
        }

        $this->assign("ret",$ret);

        //样音列表
        $res=db("dub")->where(["fid"=>2,"te"=>0])->order(["sort asc","id desc"])->select();

        foreach($res as $ks => $vs){
            $res[$ks]['type']=$type;

            foreach($res[$ks]['type'] as $kts => $vts){
                $res[$ks]['type'][$kts]['list']=db("dub_video")->where(["did"=>$vs['id'],"tid"=>$vts['tid']])->order(["sort asc","id desc"])->select();
            }
        }

        $this->assign("res",$res);

        return $this->fetch();
    }
    /**
    * 获取案例视频
    *
    * @return void
    */
    public function get_cases()
    {
        $id=input("id");

        $re=db("dub_cases")->where("id",$id)->find();

        if($re){

            if($re['video']){
                 echo $re['video'];
            }else{
                echo '0';
            }

        }else{
            echo '0';
        }
    }
    /**
    * 获取数据
    *
    * @return void
    */
    public function get_info()
    {
        $page=input("page");

        $site=10*$page;

        $type=db("dub_type")->where("fids",2)->order(["tsort asc","tid desc"])->select();

        $ret=db("dub")->where(["fid"=>2,"te"=>0])->order(["sort asc","id desc"])->limit($site,2)->select();

        foreach($ret as $k => $v){
            $ret[$k]['type']=$type;

            foreach($ret[$k]['type'] as $kt => $vt){
                $ret[$k]['type'][$kt]['list']=db("dub_video")->where(["did"=>$v['id'],"tid"=>$vt['tid']])->order(["sort asc","id desc"])->select();
            }
        }

        echo json_encode($ret);
    }
}