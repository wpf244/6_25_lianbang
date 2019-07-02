<?php
namespace app\index\controller;

class Join extends BaseHome
{
    public function index()
    {
        $lb=db("lb")->where("fid",19)->find();

        $this->assign("lb",$lb);

        $lbg=db("lb")->where("fid",20)->find();

        $this->assign("lbg",$lbg);

        $res=db("join")->order(["sort asc","id desc"])->select();

        $this->assign("res",$res);
        
        return $this->fetch();
    }
    public function save()
    {
     
        $file=request()->file("file_name");

        if($file){
            $info = $file->validate(['size'=>314572800,'ext'=>['zip','rar']])->move(ROOT_PATH . 'public' . DS . 'uploads');

            if($info){
                $pa=$info->getSaveName();
                $path=str_replace("\\", "/", $pa);
                $paths='/uploads/'.$path;
    
             //   var_dump($paths);exit;
    
                $data['file_name']=$paths;

                $data['username']=input("username");
                $data['phone']=input("phone");
                $data['jid']=input("jid");
                
                $data['time']=time();
                
                $re=db("resume")->insert($data);

                if($re){
                    $this->success("提交成功");
                }else{
                    $this->error("提交失败");
                }
            }else{
                $this->error("请上传正确的zip或rar附件类型,");
            }
           
        }else{
            $this->error("请上传附件");
        }

        

       
    }
  
   
}