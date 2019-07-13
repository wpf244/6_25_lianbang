<?php
namespace app\index\controller;

use think\Controller;

class Pay extends Controller
{
    public function notify()
    {
       
        
        //获取返回的xml
        $testxml  = file_get_contents("php://input");
        //将xml转化为json格式
        $jsonxml = json_encode(simplexml_load_string($testxml, 'SimpleXMLElement', LIBXML_NOCDATA));
     //   db("news")->where("id",2)->update(["content"=>$jsonxml]);
        //转成数组
        $result = json_decode($jsonxml, true);

       
        
        if($result){
            //如果成功返回了
            if($result['return_code'] == 'SUCCESS'){
                //进行改变订单状态等操作。。。。
                $order_code= $result['out_trade_no'];

                $pay_type=$result['attach'];

                $re=db("car_dd")->where("code",$order_code)->find();
                $id=$re['id'];

                if($pay_type == 1){
                    if($re['status_ding'] == 0){
                        $data['status_ding']=1;

                        $data['code']="CK-".uniqid();

                        db("car_dd")->where("id",$id)->update($data);    
                    }
                }

                if($pay_type == 2){
                    if($re['status_zhong'] == 0){
                        $data['status_zhong']=1;
                        $data['code']="CK-".uniqid();
                        db("car_dd")->where("id",$id)->update($data);    
                    }
                }

                if($pay_type == 3){
                    if($re['status_wan'] == 0){
                        $data['status_wan']=1;
                        $data['status']=3;
                        
                        db("car_dd")->where("id",$id)->update($data);   
                        
                        //用户增加积分
                        $money=$re['money'];

                        $ti=db("cash_s")->where("id",1)->find();
                        $fei=$ti['num']/100;

                        $inetg=$money*$fei;

                        $uid=$re['uid'];

                        db("user")->where("uid",$uid)->setInc("integ",$inetg);
                    }
                }

                
            }
        }
    }
}