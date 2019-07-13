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

        $money=db("dub_type")->where("fids",5)->order(["tsort asc","tid desc"])->select();

        $this->assign("money",$money);


        //特价专区
        $ret=db("dub")->where(["fid"=>2,"te"=>1])->order(["sort asc","id desc"])->limit(3)->select();

        foreach($ret as $k => $v){
            $ret[$k]['type']=$type;

            foreach($ret[$k]['type'] as $kt => $vt){
                $ret[$k]['type'][$kt]['list']=db("dub_video")->where(["did"=>$v['id'],"tid"=>$vt['tid']])->order(["sort asc","id desc"])->select();
            }
        }

        $this->assign("ret",$ret);

        $lid=input("lid");

        $tid=input("tid");

        $aid=input("aid");

        $mid=input("mid");

        $yid=input("yid");

        $sex=input("sex");

        $title=input("title");

        $map=[];



        if($lid || $sex || $tid || $aid || $mid || $yid || $title){

            if($lid){
                $map['lid']=['eq',$lid];

                $arr['lid']=$lid;
            }else{
                $arr['lid']=0;
            }
            if($tid){
                $map['tid']=['eq',$tid];

                $arr['tid']=$tid;
            }else{
                $arr['tid']=0;
            }
            if($aid){
                $map['aid']=['eq',$aid];

                $arr['aid']=$aid;
            }else{
                $arr['aid']=0;
            }
            if($mid){
                $map['mid']=['eq',$mid];

                $arr['mid']=$mid;
            }else{
                $arr['mid']=0;
            }
            if($yid){
                $map['yid']=['eq',$yid];

                $arr['yid']=$yid;
            }else{
                $arr['yid']=0;
            }
            if($sex){
                if($sex == 1){
                    $map['sex']=['eq',1];
                }else{
                    $map['sex']=['eq',0];
                }
                $arr['sex']=$sex;
            }else{
                $arr['sex']=0;
            }
            if($title){
                $map['name|code']=['like',"%".$title."%"];
                $arr['title']=$title;
            }else{
                $arr['title']='';
            }
        }else{
            $arr['lid']=0;
            $arr['tid']=0;
            $arr['mid']=0;
            $arr['aid']=0;
            $arr['sex']=0;
            $arr['yid']=0;
            $arr['title']='';
        }
        $this->assign("arr",$arr);
        //样音列表
        $res=db("dub")->where(["fid"=>2,"te"=>0])->where($map)->order(["sort asc","id desc"])->select();

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
    /**
    * 获取样音信息
    *
    * @return void
    */
    public function get_person()
    {
        $id=input("id");

        $re=db("dub")->field("name,code,tags")->where("id",$id)->find();

        if($re){
            echo  json_encode($re);
        }else{
            echo 0;
        }
    }
    public function get_persons()
    {
        $id=input("id");

        $re=db("dub_video")->field("did,code,tags")->where("id",$id)->find();

        $dub=db("dub")->where("id",$re['did'])->find();

        $re['name']=$dub['name'];

        if($re){
            echo  json_encode($re);
        }else{
            echo 0;
        }
    }
    /**
    * 获取样音的mp3文件
    *
    * @return void
    */
    public function get_musics()
    {
        $id=input("id");

        $re=db("dub")->field("image,name,code")->where("id",$id)->find();

        if($re){
            if($re['image']){
                echo json_encode($re);
            }else{
                echo '0';
            }
        }else{
            echo '0';
        }
    }
    public function get_music()
    {
        $id=input("id");

        $re=db("dub_video")->field("image,tags,code")->where("id",$id)->find();

        if($re){
            if($re['image']){
                echo json_encode($re);
            }else{
                echo '0';
            }
        }else{
            echo '0';
        }
    }
    /**
    * 获取mp4文件
    *
    * @return void
    */
    public function get_videos()
    {
        $id=input("id");

        $re=db("dub")->field("video")->where("id",$id)->find();

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
    public function get_video()
    {
        $id=input("id");

        $re=db("dub_video")->field("video")->where("id",$id)->find();

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
    * 更多案例
    *
    * @return void
    */
    public function cases()
    {
        $res=db("dub_cases")->order(["sort asc","id desc"])->paginate(8);

        $this->assign("res",$res);

        $page=$res->render();

        $this->assign("page",$page);
        
        return $this->fetch();
    }
}