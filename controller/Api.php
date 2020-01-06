<?php

/**
 * Created by PhpStorm.
 * User: woodenwang
 * Date: 2019/5/10
 * Time: 21:25
 *
 * 接口管理
 */
header('Access-Control-Allow-Origin:*');
class ApiController
{
    /**
     * 登录接口
     */
    public function login(){

        //echo json_encode($_POST['managerUser']."------>".$_POST['managerPwd']);
        $adminInfo=M('admin')->selectOneAdminInfo($_POST["managerUser"]);
        if (!empty($adminInfo)){
            $pwd = empty($adminInfo["password"])?"":$adminInfo["password"];
            if(changePasswordType($_POST["managerPwd"]) == $pwd){
                echo json_encode("密码正确",JSON_UNESCAPED_UNICODE);
            }else{
                echo json_encode("密码错误",JSON_UNESCAPED_UNICODE);
            }
        }else{
            echo json_encode("账号不存在",JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     *注册接口
     */
    public function regist(){


        if ($_POST['adminPwd'] == $_POST['reAdminPwd']){
            //重复密码相同，判断账号是否才能在：
            if(M('admin')->selectOneAdmin($_POST['adminName'])){
                //不存在 该账号
                $code = M('admin')->selectChangePwdInfo($_POST['adminName']);
                if($code['code'] == $_POST['validate'] && (time()-strtotime($code['oldTime']))< 60){
                    $pwd=changePasswordType($_POST['adminPwd']);
                    $returnData = M('admin')->insertNewAdmin($_POST['adminName'],$pwd);
                    if($returnData){
                        echo json_encode("注册成功",JSON_UNESCAPED_UNICODE);
                    }else{
                        echo json_encode("注册失败",JSON_UNESCAPED_UNICODE);
                    }
                }else{
                    echo json_encode("验证码错误",JSON_UNESCAPED_UNICODE);
                }
            }else{
                //账号存在， 返回错误
                echo json_encode("注册账号重复",JSON_UNESCAPED_UNICODE);
            }
        }else{
            // 密码不同，返回注册页面，并提醒
            echo json_encode("密码不同",JSON_UNESCAPED_UNICODE);
        }
    }




    public function getHotelImg(){

        $returnMysql_img = M('hotel')->selectSomeOnePicture((int)delRoute($_GET)['id']);
        echo  json_encode($returnMysql_img[0],JSON_UNESCAPED_UNICODE);
    }

    public function getHotelRoom(){
        $returnMysql_room = M('hotel')->selectSomeOneRoom(delRoute($_GET)['id']);
        echo  json_encode($returnMysql_room[0],JSON_UNESCAPED_UNICODE);
    }
    public function getOtherInfo(){
        $returnMysql_img = M('hotel')->selectSomeOnePicture((int)delRoute($_GET)['id'])[0];
        $returnMysql_room = M('hotel')->selectSomeOneRoom(delRoute($_GET)['id'])[0];
        echo  json_encode(array_merge($returnMysql_img,$returnMysql_room),JSON_UNESCAPED_UNICODE);
    }

    public function getHotelByName(){

        $returnData =  M('hotel')->after_get($_POST['name'] );
        echo  json_encode($returnData,JSON_UNESCAPED_UNICODE);
    }

    public function getPlayInfo(){
        $returnData =  M('playInfo')->after_get($_POST['title'] );
        echo  json_encode($returnData,JSON_UNESCAPED_UNICODE);
    }

    public function getPoint(){
        $returnData =  M('point')->after_get($_POST['title'] );
        echo  json_encode($returnData,JSON_UNESCAPED_UNICODE);
    }

}