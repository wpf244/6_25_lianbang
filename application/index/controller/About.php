<?php
namespace app\index\controller;

class About extends BaseHome
{
    public function index()
    {
        $re=db("about")->where("id",1)->find();

        $this->assign("re",$re);
        
        return $this->fetch();
    }
    /**
    * 资质荣誉
    *
    * @return void
    */
    public function honor()
    {
        $res=db("honor")->where(["status"=>1,"type"=>1])->order(["sort asc","id desc"])->paginate(6);

        $this->assign("res",$res);

        $page=$res->render();

        $this->assign("page",$page);
        
        return $this->fetch();
    }
    /**
    * 详情
    *
    * @return void
    */
    public function detail()
    {
        $id=input("id");

        $re=db("honor")->where("id",$id)->find();

        $this->assign("re",$re);

        //上一篇
        $rep=db("honor")->where(["status"=>1,"type"=>1])->where("id<$id")->order(["id asc"])->limit(1)->find();

        $this->assign("rep",$rep);

        //下一篇
        $ren=db("honor")->where(["status"=>1,"type"=>1])->where("id>$id")->order(["id asc"])->limit(1)->find();

        $this->assign("ren",$ren);

        return $this->fetch();
    }
    /**
    * 公司图片
    *
    * @return void
    */
    public function photo()
    {
        $res=db("honor")->where(["status"=>1,"type"=>2])->order(["sort asc","id desc"])->paginate(6);

        $this->assign("res",$res);

        $page=$res->render();

        $this->assign("page",$page);
        
        return $this->fetch();
    }
    public function detail_photo()
    {
        $id=input("id");

        $re=db("honor")->where("id",$id)->find();

        $this->assign("re",$re);

        //上一篇
        $rep=db("honor")->where(["status"=>1,"type"=>2])->where("id<$id")->order(["id asc"])->limit(1)->find();

        $this->assign("rep",$rep);

        //下一篇
        $ren=db("honor")->where(["status"=>1,"type"=>2])->where("id>$id")->order(["id asc"])->limit(1)->find();

        $this->assign("ren",$ren);

        return $this->fetch();
    }
    /**
    * 成功案例
    *
    * @return void
    */
    public function cases()
    {
        $lb=db("lb")->where("fid",4)->find();

        $this->assign("lb",$lb);

        $res=db("cases_type")->order(["sort asc","id desc"])->select();

        foreach($res as $k => $v){
            $res[$k]['list']=db("cases")->where(["status"=>1,"tid"=>$v['id']])->order(["sort asc","id desc"])->select();
        }

        $this->assign("res",$res);

        return $this->fetch();
    }
    /**
    * 解决方案
    *
    * @return void
    */
    public function project()
    {
        $lb1=db("lb")->where("fid",5)->find();

        $this->assign("lb1",$lb1);

        $lb2=db("lb")->where("fid",6)->find();

        $this->assign("lb2",$lb2);

        $lb3=db("lb")->where("fid",7)->find();

        $this->assign("lb3",$lb3);

        $lb4=db("lb")->where("fid",8)->find();

        $this->assign("lb4",$lb4);

        $lb5=db("lb")->where("fid",9)->find();

        $this->assign("lb5",$lb5);
        
        return $this->fetch();
    }
    /**
    * 公司优势
    *
    * @return void
    */
    public function advan()
    {
        $lb1=db("lb")->where("fid",10)->find();

        $this->assign("lb1",$lb1);

        $lb2=db("lb")->where(["fid"=>11,"status"=>1])->order(["sort asc","id asc"])->select();

        $this->assign("lb2",$lb2);

        $lb3=db("lb")->where("fid",12)->find();

        $this->assign("lb3",$lb3);

        $lb4=db("lb")->where("fid",13)->find();

        $this->assign("lb4",$lb4);

        $lb5=db("lb")->where("fid",14)->find();

        $this->assign("lb5",$lb5);

        $lb6=db("lb")->where("fid",15)->find();

        $this->assign("lb6",$lb6);

        $lb7=db("lb")->where("fid",16)->find();

        $this->assign("lb7",$lb7);

        $lb8=db("lb")->where("fid",17)->find();

        $this->assign("lb8",$lb8);

        $lb9=db("lb")->where(["fid"=>18,"status"=>1])->order(["sort asc","id asc"])->select();

        $this->assign("lb9",$lb9);

       
        
        return $this->fetch();
    }
    public function news()
    {
        $res=db("news")->where(["status"=>1])->order(["sort asc","id desc"])->paginate(5);

        $this->assign("res",$res);

        $page=$res->render();

        $this->assign("page",$page);
        

        return $this->fetch();
    }
    public function detail_news()
    {
        $id=input("id");

        $re=db("news")->where("id",$id)->find();

        $this->assign("re",$re);

        db("news")->where("id",$id)->setInc("browse",1);

        //上一篇
        $rep=db("news")->where(["status"=>1])->where("id<$id")->order(["id asc"])->limit(1)->find();

        $this->assign("rep",$rep);

        //下一篇
        $ren=db("news")->where(["status"=>1])->where("id>$id")->order(["id asc"])->limit(1)->find();

        $this->assign("ren",$ren);

        return $this->fetch();


    }
}