<?php
namespace app\index\controller;


use think\Loader;
use think\Db;

Loader::import('WxPay.WxPay', EXTEND_PATH, '.NativePay.php');
Loader::import('WxPay.WxPay', EXTEND_PATH, '.Api.php');
Loader::import('WxPay.WxPay', EXTEND_PATH, '.JsApiPay.php');


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
            $info = $file->validate(['size'=>50240000,'ext'=>['zip','rar','doc','docx','xls','xlsx']])->move(ROOT_PATH . 'public' . DS . 'uploads');

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
                return  ['code'=>0,'msg'=>'请上传正确的附件类型,文件大小10M'];
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
        $uid=session("userid");
        
        //待报价订单
        $res=db("car_dd")->where(["status"=>1,"uid"=>$uid])->select();

        $this->assign("res",$res);

        //待付款订单

        $ref=db("car_dd")->where(["status"=>2,"uid"=>$uid])->select();

        $this->assign("ref",$ref);

        //待下载
        $rex=db("car_dd")->where(["status"=>4,"uid"=>$uid])->select();

        $this->assign("rex",$rex);

        //已完成
        $rew=db("car_dd")->where(["status"=>5,"uid"=>$uid])->select();

        $this->assign("rew",$rew);



        
        return $this->fetch();
    }
    public function change(){
        $id=input('id');
        $re=db("car_dd")->where("id=$id")->find();
        if($re['status'] == 4){
           $del=db("car_dd")->where("id=$id")->setField("status",5);
           if($del){
               echo '1';
           }else{
               echo '2';
           }
        }else{
            echo '0';
        }
       
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
        $did=input("did");

        $re=db("car_dd")->where("id",$did)->find();

        if($re['status_ding'] == 0){
            $re['moneys']=$re['money_ding'];
            $re['pay_type']=1;
        }else{
            if($re['status_zhong'] == 0){
                $re['moneys']=$re['money_zhong'];
                $re['pay_type']=2;
            }else{
                $re['moneys']=$re['money_wan'];
                $re['pay_type']=3;
            }
        }

        $this->assign("re",$re);
        
        return $this->fetch();
    }
    public function getqrcode()
    {
        $did=input("did");

        $re=db("car_dd")->where("id",$did)->find();

        $order=$re['code'];

        if($re['status_ding'] == 0){
            $re['moneys']=$re['money_ding'];
            $pay_type=1;
        }else{
            if($re['status_zhong'] == 0){
                $re['moneys']=$re['money_zhong'];
                $pay_type=2;
            }else{
                $re['moneys']=$re['money_wan'];
                $pay_type=3;
            }
        }

        $money=($re['moneys']*100);

        $this->assign("re",$re);

        $data=db("payment")->where("id",1)->find();

   
        // $input = new \WxPayUnifiedOrder();
        // $input->SetBody("商品");
        // $input->SetOut_trade_no("$order");
        // $input->SetTotal_fee("$money");
        // $input->SetNotify_url("http://xiangyan.dd371.com/Index/Pay/notify/");
        // $input->SetTrade_type("JSAPI");
        // $input->SetTime_start(date("YmdHis"));
        // $input->SetTime_expire(date("YmdHis", time() + 600));

        $input = new \WxPayUnifiedOrder();
        $input->SetBody("商品");
        $input->SetAttach("$pay_type");
        $input->SetOut_trade_no("$order");
        $input->SetTotal_fee("$money");
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 6000));
        $input->SetGoods_tag("test");
        $input->SetNotify_url("http://lianbang.dd371.com/Index/Pay/notify/");
        $input->SetTrade_type("NATIVE");
        $input->SetProduct_id("123456789");

        $notify = new \NativePay();

        $result = $notify->GetPayUrl($input,$data);

        if($result){
        //   var_dump($result);exit;
           $url=$result['code_url'];

           $img=Code($url);

           echo $img;

        }else{
            echo '0';
        }
    }
    public function integ()
    {
        return $this->fetch();
    }
    public function ti()
    {
        $uid=session("userid");

        $res=db("money_log")->where("uid",$uid)->order("mid desc")->select();

        $this->assign("res",$res);
        
        return $this->fetch();
    }
    public function save_ti()
    {
        $uid=session("userid");
        $shop=db("user")->where("uid",$uid)->find();
        $money=$shop['integ'];
        $moneys=input("money");
        $ti=db("cash_s")->where("id",1)->find();
        $fei=$ti['num'];
        if($money < $moneys){
            echo '1';
        }else{
            $data['uid']=$uid;
            $data['moneys']=$moneys;
            $data['proce']=$moneys*$fei/100;
            $data['money']=$moneys-$data['proce'];
            $data['content']=input("content");
            $data['time']=time();

            // 启动事务
            Db::startTrans();
            try{
                db("money_log")->insert($data);
                db("user")->where("uid",$uid)->setDec("integ",$moneys);
                
               
                // 提交事务
                Db::commit();    

                
            } catch (\Exception $e) {

             
                // 回滚事务
                Db::rollback();

                echo '2';
            }

            echo '0';
        }
    }
    public function dope()
    {
        $uid=session("userid");

        $res=db("dope")->where("uid",$uid)->order("id desc")->paginate(3);

        $this->assign("res",$res);

        $page=$res->render();

        $this->assign("page",$page);
        
        return $this->fetch();
    }
    public function get_jie()
    {
        $id=input("id");
        $pay=input("pay");

        $re=db("car_dd")->where("id",$id)->find();

        if($pay == 1){
            if($re['status_ding'] == 1){
                echo '1';
            }
        }
        if($pay == 2){
            if($re['status_zhong'] == 1){
                echo '1';
            }
        }
        if($pay == 3){
            if($re['status_wan'] == 1){
                echo '1';
            }
        }
    }
}