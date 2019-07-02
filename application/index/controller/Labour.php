<?php
namespace app\index\controller;

class Labour extends BaseHome
{
    public function index()
    {
        $lb=db("labour")->where("fid",1)->find();

        $this->assign("lb",$lb);

        //语种
        $type=db("labour_type")->order(["tsort asc","tid desc"])->select();

        $this->assign("type",$type);

        $pid=input("pid");

        $sex=input("sex");

        if($pid || $sex){

            $map=[];
            if($pid){
                $map['pid']=['eq',$pid];

                $arr['pid']=$pid;
            }else{
                $arr['pid']=0;
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
            $res=db("labour")->alias("a")->where(["fid"=>2])->where($map)->join("labour_type b","a.pid=b.tid")->order(["sort asc","id desc"])->paginate(6,false,['query'=>request()->param()]);
        }else{
            $arr['sex']=0;
            $arr['pid']=0;
            $res=db("labour")->alias("a")->where(["fid"=>2,"recome"=>1])->join("labour_type b","a.pid=b.tid")->order(["sort asc","id desc"])->paginate(6);
        }


        
        $this->assign("arr",$arr);
        $this->assign("res",$res);

        $page=$res->render();

        $this->assign("page",$page);
        
        return $this->fetch();
    }
    public function save()
    {
        $data=input("post.");
        
     

        $data['username']=strip_tags(input("username"));

        $data['content']=strip_tags(input("content"));

        $data['time']=time();

        $re=db("demand")->insert($data);

        if($re){
            $this->success("提交成功");
        }else{
            $this->error("提交失败");
        }

    }
}