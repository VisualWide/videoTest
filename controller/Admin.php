<?php
/**
 * Created by PhpStorm.
 * User: woodenwang
 * Date: 2019/8/20
 * Time: 20:14
 */
/*
 *
 *
 * Unable to load template  模板路径错误
 *
 *
 * */


class AdminController
{
    /**
     * 此乃框架显示
     */
    public function memcenter($serverflag=0){
        //是否存在用户session
        session_start();
      if( isset($_SESSION["admin"])  ){
            if(!empty($_SESSION["admin"])){
                //var_dump($_SESSION["admin"]);
                //判定用户等级
                $adminInfo = M('admin')->selectOneAdminInfo($_SESSION["admin"]);
                $adminInfo['levelName'] = M('admin')-> selectAdminName($_SESSION["admin"]);
                $adminInfo['name'] = $adminInfo['account'];

               // echo $adminInfo["name"],$adminInfo["level"];
                SmartyChild::getSmarty()->assign("adminInfo",$adminInfo);
                //不同的等级加载不同的模块
//                switch (msg){
//                    case 'Other_Close':
//                        errorFun('未穿工服进入！！！',1,1,'frock.mp3')
//                            break;
//                    case 'Head':
//                        errorFun('未佩戴安全帽！！！',1,1,'safeHat.mp3')
//                            break;
//                    case 'Calling':
//                        errorFun('违规打电话！！！',1,1,'calling.mp3')
//                            break;
//                    case 'Smoking':
//                        errorFun('违规吸烟！！！',1,1,'smoking.mp3')
//                            break;
//                    case 'Fire':
//                        errorFun('火灾报警 ！！！',1,1,'seeFire.mp3')
//                            break;
//                    case 'Fog':
//                        errorFun('烟雾报警 ！！！',1,1,'seeFog.mp3')
//                            break;
//                    case 'Dangerous':
//                        errorFun('危险区闯入 ！！！',1,1,'dangerous.mp3')
//                            break;
//                    default :
//                }


                $alertContent='switch (msg){';
                $returnData_allC =  M('alert')->selectAll_url();
                foreach($returnData_allC as $items=>$item){
                    $alertContent.=" case '".$item['algorithm_url']."':
                                       errorFun('".$item['alert_content']."','".$item['is_alert']."','".$item['is_broadcast']."','".$item['music']."')
                                    break;";
                    //var_dump($item['algorithm_url']);

                }
                $alertContent.='}';
               // var_dump( $alertContent );

                SmartyChild::getSmarty()->assign("alertContent",$alertContent);


                $alertErrorBtn = '' ;
                $urlContent = '' ;
                switch ($adminInfo['level']){
                    case 1:
                        //超级管理员模块
                        $urlContent=ADMIN_LEVEL_1;
                        $alertErrorBtn = ERROR_ALERT_BTN;
                        break;
                    case 2:
                        //other模块
                        $urlContent=ADMIN_LEVEL_2;
                        
                        break;
                    case 3:
                        $urlContent=ADMIN_LEVEL_3;
                        
                        break;
                    default:
                        
                }
                
                
                SmartyChild::getSmarty()->assign("alertErrorBtn",$alertErrorBtn);
                    
                SmartyChild::getSmarty()->assign("serverflag",$serverflag);
                
                SmartyChild::getSmarty()->assign("urlContent",$urlContent);

                SmartyChild::getSmarty()->display('view\admin\memcenter.html');
            }else{
                redirect('?c=admin&a=login',1,alert(returnData(510,'长时间未操作，用户已下线')));
            }
      }else{
          redirect('?c=admin&a=error',1,alert(returnData(000,'致命操作')));
      }

    }

    /**
     *  此乃首页显示
     * @param null $code
     */
    public function index($code=null){
		define("USER_IP",$_SERVER["REMOTE_ADDR"]);
        session_start();
       // $adminInfo=$_SESSION["admin"];
        $adminInfo = M('admin')->selectOneAdminInfo($_SESSION["admin"]);
        $adminInfo['levelName'] = M('admin')-> selectAdminName($_SESSION["admin"]);
        $adminInfo['name'] = $adminInfo['account'];
        //获取 当前 算法的种类
       // var_dump(M('algorithm')->getCount());
        //获取 摄像头  的 数量
       // var_dump(M('camera')->getCount());
        SmartyChild::getSmarty()->assign("algorithmNum",M('algorithm')->getRowCount());
        SmartyChild::getSmarty()->assign("cameraNum",M('camera')->getRowCount());
        SmartyChild::getSmarty()->assign("adminInfo",$adminInfo);

//        var_dump(START_TIME);
//        var_dump(ceil((time()-strtotime(START_TIME))/(60*60*24)));
        SmartyChild::getSmarty()->assign("serverStartTime",ceil((time()-strtotime(START_TIME))/(60*60*24)));
        //alertSomeWring(array('type'=>'登陆成功'));
        SmartyChild::getSmarty()->display('view\admin\index.html');
    }

    /**
     *此乃登陆界面
     */
    public function login(){
       //先判断是否存在传值，没有则是刚进来
        if(!isset($_POST["adminName"]) && !isset($_POST["adminPwd"])) {
           SmartyChild::getSmarty()->display(LOGIN_URI);
        }else{
                //2用户名，密码的检测
                $adminInfo=M('admin')->selectOneAdminInfo($_POST["adminName"]);
                if (!empty($adminInfo)){
                    $pwd = empty($adminInfo["password"])?"":$adminInfo["password"];
                    if(changePasswordType($_POST["adminPwd"]) == $pwd){
                        //用户密码正确
                        //存储session 记录登陆用户
                        session_start();
                        $_SESSION['admin']=$adminInfo['account'];

                        //redirect('?c=admin&a=memcenter',0.2,alert(returnData(200,$_POST['adminName'].' is login success')));
                       redirect('?c=admin&a=memcenter',0.2,alertSomeWring(array('type'=>'登陆成功')));
                    }else{
                        alert(returnData(501,'用户名密码错误'));
                        SmartyChild::getSmarty()->display(LOGIN_URI);
                    }
                }else{
                    die("账号不存在");
                    SmartyChild::getSmarty()->display(LOGIN_URI);
                }

        }
    }

    /**
     * 这是退出操作
     */
    public function loginOut(){
        //1.清除cookie
        session_start();
        session_destroy();
        //2.跳转网页，要是别人说退出慢，这里的数值改一下，别改0，会没有提示的
        redirect('?c=admin&a=login',1,alert(returnData(200,'退出成功')));

    }

    /**
     *注册
     */
    public function register(){
        /*
         * 业务逻辑：1.判断是什么页面；2.传值后验证数据；3.是否在规定时间内完成验证；4.是否存在该账号
         * */
        //判断是否存在传过来的东西
        if(isset($_POST['adminName']) && $_POST['adminName']!=null){
            /*["adminName"]=> string(10) "woodenwang"
            ["validate"]=> string(10) "woodenwang"
            ["adminPwd"]=> string(12) "admin_passwd"
            ["reAdminPwd"]=> string(12) "admin_passwd"*/
            //判断传过来的密码是否相同
            if ($_POST['adminPwd'] == $_POST['reAdminPwd']){
                //重复密码相同，判断账号是否才能在：
                if(M('admin')->selectOneAdmin($_POST['adminName'])){
                    //不存在 该账号
                    $code = M('admin')->selectChangePwdInfo($_POST['adminName']);
                    if($code['code'] == $_POST['validate'] && (time()-strtotime($code['oldTime']))< 60){
                        $pwd=changePasswordType($_POST['adminPwd']);
                        $returnData = M('admin')->insertNewAdmin($_POST['adminName'],$pwd);
                        if($returnData){
                            session_start();
                            $_SESSION['admin']=$_POST['adminName'];
                            M('admin')->deleteChangePwdInfo($_POST['adminName']);
                            redirect('?c=admin&a=memcenter',1,alert(returnData(200,$_POST['adminName'].' 注册成功')));
                        }else{
                            die("mysql error");
                        }
                    }else{
                        die("验证码有误");
                    }
                }else{
                    //账号存在， 返回错误
                    die("账号存在，请更换账号");
                }
            }else{
                // 密码不同，返回注册页面，并提醒
                die("PWD ERROR");
            }
        }else{
            //没有传值说明是刚进来，那就加载页面呗
            SmartyChild::getSmarty()->display(REGISTER_URI);
        }
    }
    public  function sendEmail(){
        header('Access-Control-Allow-Origin:*');
        //
        //获取Email,检查数据库是否存在该数据，存在返回error;
            if (empty(delRoute($_GET)['email'])){
                //获取验证码的操作
                echo "未输入账号";
            }else{
                if (M('admin')->selectOneAdmin(delRoute($_GET)['email'])){
                    //存在账号
                    $sendContent = rand(100000,999999);
                    $this->sendChangePwdEmail(delRoute($_GET)['email'],APP_NAME."为您提供修改验证码",$sendContent);
                }else{
                    //不存在账号,注册使用；
                    $sendContent = rand(100000,999999);
                    $this->sendChangePwdEmail(delRoute($_GET)['email'],APP_NAME."为您提注册供验证码",$sendContent);
                }
            }

    }

    private function sendChangePwdEmail($sendTo,$sendTitle,$sendContent){
        $forName = APP_NAME;//谁发的
        $title = $sendTitle;//主题是什么
        $content = "<h3>当前验证码:</h3>&nbsp;&nbsp;&nbsp;&nbsp;<h1 style='color: #f00;'>".$sendContent."</h1>";      //内容
        //此处最好的做法是存储于redis缓存中，此处我们使用mysql

        if(!M('admin')->insertChangePwd($sendTo,$sendContent,date("Y-m-d H:i:s",time()))) die("数据出错，联系管理员");

        echo $content;
       // exit;
        include "extend/email/mail.php";
        $getArr=send_mail($sendTo,$forName,$title,$content);
        var_dump($getArr);
    }

    /**
     *更换密码的操作
     */
    public function changePwd(){
        $otherHtml="";
        SmartyChild::getSmarty()->assign('otherHtml',$otherHtml);
        SmartyChild::getSmarty()->assign('title','修改密码');
        SmartyChild::getSmarty()->display(PASSWORD_URI);
    }

    /**
     *丢失密码的操作
     */
    public function losePwd(){
        if(empty($_POST)){
            $otherHtml = "<strong>已经有账号？ <a href='".LOGIN_URL."' >立即登陆&raquo;</a></strong><br /><br /><strong>还没有账号？ <a href='".REGISTER_URL."' >立即注册&raquo;</a></strong>";
            SmartyChild::getSmarty()->assign('title','忘记密码');
            SmartyChild::getSmarty()->assign('otherHtml',$otherHtml);
            SmartyChild::getSmarty()->display(PASSWORD_URI);
        }else{
            $this->validateChangePwd($_POST);
        }

    }
    private function validateChangePwd($_post){
        if ($_post['adminPwd'] == $_post['reAdminPwd']) {
            //重复密码相同，判断账号是否才能在：
            if (!M('admin')->selectOneAdmin($_post['adminName'])) {
                //存在 该账号
                $code = M('admin')->selectChangePwdInfo($_post['adminName']);
                if ($code['code'] == $_post['validate'] && (time() - strtotime($code['oldTime'])) < 80) {
                    $pwd = changePasswordType($_post['adminPwd']);
                    $returnData = M('admin')->updateNewAdmin($_post['adminName'], $pwd);
//                    var_dump($returnData);
//                    die();
                    if ($returnData) {
                        M('admin')->deleteChangePwdInfo($_post['adminName']);
                        session_start();
                        $_SESSION['admin'] = $_post['adminName'];
                        redirect('?c=admin&a=memcenter', 1, alert(returnData(200, $_post['adminName'] . ' 改密码成功')));
                    } else {
                        M('admin')->deleteChangePwdInfo($_post['adminName']);
                        die("mysql error");
                    }
                } else {
                    M('admin')->deleteChangePwdInfo($_post['adminName']);
                    die("验证码有误");

                }
            } else {
                //账号存在， 返回错误
                M('admin')->deleteChangePwdInfo($_post['adminName']);
                die("账号不存在");

            }
        } else {
            // 密码不同，返回注册页面，并提醒
            M('admin')->deleteChangePwdInfo($_post['adminName']);
            die("PWD ERROR");

        }
    }

    /*开启服务于关闭服务
     *
     * */
     public function startServer(){
        $this->memcenter( 0 );
        
    }
    
     public function stopServer(){
         $this->memcenter( 1 );
        
    }



    public function info(){
        session_start();
        $_returnData = M('admin')->selectOneInfo($_SESSION['admin']);

        //var_dump( $_returnData );

        SmartyChild::getSmarty()->assign('info',$_returnData);
        SmartyChild::getSmarty()->display('view/admin/admin/info.html');
    }

    public function infoChange(){
        //var_dump( $_POST );
        $admin_account = $_POST['info_account'];
        $admin_pwd = changePasswordType($_POST['info_pwd']);

        var_dump( $admin_pwd );
        exit();

        M('admin')->updateNewAdmin( $admin_account , $admin_pwd );

        redirect('?c=admin&a=info');


    }
    
    


    /**
     *这是错误页面
     */
    public function error(){
        SmartyChild::getSmarty()->display(ERROR_404);
    }
}