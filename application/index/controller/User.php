<?php
namespace app\index\controller;

class User extends BaseUser
{
    public function order()
    {
        $res=db("langs")->where("fid",1)->order(["sort asc","id desc"])->select();

        $this->assign("res",$res);

        $aim=db("langs")->where("fid",2)->order(["sort asc","id desc"])->select();

        $this->assign("aim",$aim);

        $major=db("langs")->where("fid",3)->order(["sort asc","id desc"])->select();

        $this->assign("major",$major);
        
        return $this->fetch();
    }
    public function save_file()
    {
        $file=request()->file("file_name");

        if($file){
            $info = $file->validate(['size'=>50240000,'ext'=>['zip','rar']])->move(ROOT_PATH . 'public' . DS . 'uploads');

            if($info){
                $pa=$info->getSaveName();
                $path=str_replace("\\", "/", $pa);
                $paths='/uploads/'.$path;
    
             //   var_dump($paths);exit;
    
                $data['file']=$paths;
                $data['uid']=session("userid");

                $res=db("car")->where(["uid"=>$data['uid']])->find();

                if($res){
                    db("car")->where(["uid"=>$data['uid']])->delete();
                }

                
                $re=db("car")->insert($data);

                $id=db("car")->getLastInsID();

                if($re){
                    return  ['code'=>1,'msg'=>'上传成功','id'=>$id];
                }else{
                    return  ['code'=>0,'msg'=>'系统繁忙稍后再试'];
                }
            }else{
                return  ['code'=>0,'msg'=>'请上传正确的zip或rar附件类型,文件大小10M'];
            }
           
        }else{
            return  ['code'=>0,'msg'=>'请上传文件'];
        }
    }
    public function save_car()
    {
        $id=input("id");

        $data=input("post.");

        $re=db("car")->where("id",$id)->find();

        if($re){
            $res=db("car")->where("id",$id)->update($data);

            if($res){
                echo '0';
            }else{
                echo '2';
            }

        }else{
            echo '1';
        }
    }
    public function demand()
    {
        $cid=input("cid");

        $this->assign("cid",$cid);

        $res=db("langs")->where("fid",4)->order(["sort asc","id desc"])->select();

        $this->assign("res",$res);
        
        return $this->fetch();
    }
    public function save_dd()
    {
        $data=input("post.");

        $cid=input("cid");

        $uid=session("userid");

        $re=db("car")->where(["id"=>$cid,"uid"=>$uid])->find();

        if($re){
            
            $data['langs']=$re['langs'];

            $data['aim']=$re['aim'];

            $data['major']=$re['major'];

            $data['file']=$re['file'];

            $data['code']='CK-'.\uniqid();

            $data['time']=time();

            $data['uid']=$uid;

            unset($data['cid']);

            db("car")->where(["id"=>$cid,"uid"=>$uid])->delete();

            db("car_dd")->insert($data);

            $id=db("car_dd")->getLastInsID();

            if($id){
                echo $id;
            }else{
                echo '0';
            }

        }else{
            echo '0';
        }
    }
    public function success_dd()
    {
        $did=input("did");

        $re=db("car_dd")->where("id",$did)->find();

        $this->assign("re",$re);
        
        return $this->fetch();
    }
    public function index()
    {
        //待报价订单
        $res=db("car_dd")->where("status",1)->select();

        $this->assign("res",$res);

        //待付款订单

        
        return $this->fetch();
    }
    public function delete(){
        $id=input('id');
        $re=db("car_dd")->where("id=$id")->find();
        if($re){
           $del=db("car_dd")->where("id=$id")->delete();
           if($del){
               echo '1';
           }else{
               echo '2';
           }
        }else{
            echo '0';
        }
       
    }
    /**
    * 订单详情
    *
    * @return void
    */
    public function detail()
    {
        $id=input("id");

        $re=db("car_dd")->where("id",$id)->find();

        $this->assign("re",$re);
        
        return $this->fetch();
    }
    public function pay()
    {
        return $this->fetch();
    }
}