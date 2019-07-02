<?php
namespace app\admin\controller;

class Dub extends BaseAdmin
{
    public function brief()
    {
        if(request()->isAjax()){

            $data=input("post.");

            $re=db("dub")->where("id",1)->find();
            
            if(request()->file("image")){
                 $data['image']=uploads("image");
            }else{
                $data['image']=$re['image'];
            }
            $res=db("dub")->where("id",1)->update($data);

            if($res){
                $this->success("修改成功");
            }else{
                $this->error("修改失败");
            }

        }else{
            $re=db("dub")->where("id",1)->find();

            $this->assign("re",$re);

            return $this->fetch();
        }
    }
    public function type()
    {
        $fids=input("fids");

        if(empty($fids))
        {
            $fids=1;
        }
        $map['fids']=['eq',$fids];

        $this->assign("fids",$fids);
        
        $list=db("dub_type")->where($map)->order(["tsort asc","tid desc"])->paginate(20);

        $this->assign("list",$list);

        $page=$list->render();

        $this->assign("page",$page);

        
        
        return $this->fetch();
    }
    public function save_s(){
        $id=\input('tid');
        $data=input("post.");
        if($id){
          
           $res=db('dub_type')->where("tid=$id")->update($data);
           if($res){
               $this->success("修改成功！");
           }else{
               $this->error("修改失败！");
           }
        }else{
            
            
            $re=db('dub_type')->insert($data);
            if($re){
                $this->success("添加成功！");
            }else{
                $this->error("添加失败！");
            } 
        }
         
    }
    public function modifys_s(){
        $id=input("id");
        $re=db('dub_type')->where("tid=$id")->find();
        echo json_encode($re);
    }
    public function delete_s(){
        $id=input('id');
        $re=db("dub_type")->where("tid=$id")->find();
        if($re){
           $del=db("dub_type")->where("tid=$id")->delete();
           if($del){
               echo '1';
           }else{
               echo '2';
           }
        }else{
            echo '0';
        }
       
    }
    public function sorts_s(){
        $data=input('post.');
        foreach ($data as $id => $sort){
            db('dub_type')->where(array('tid' => $id ))->setField('tsort' , $sort);
        }
        $this->redirect('type');
    }
    public function lister()
    {
        $list=db("dub")->where("fid",2)->order(["sort asc","id desc"])->paginate(20);

        $this->assign("list",$list);

        $page=$list->render();

        $this->assign("page",$page);

        $langs=db("dub_type")->where("fids",1)->order(["tsort asc","tid desc"])->select();

        $this->assign("langs",$langs);

        $type=db("dub_type")->where("fids",2)->order(["tsort asc","tid desc"])->select();

        $this->assign("type",$type);

        $age=db("dub_type")->where("fids",3)->order(["tsort asc","tid desc"])->select();

        $this->assign("age",$age);

        $mood=db("dub_type")->where("fids",4)->order(["tsort asc","tid desc"])->select();

        $this->assign("mood",$mood);
        
        return $this->fetch();
    }
}