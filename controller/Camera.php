<?php
/**
 * Created by PhpStorm.
 * User: woodenwang
 * Date: 2019/8/29
 * Time: 16:01
 *
 * 安防操作
 */


class CameraController
{


    public function index(){
//        echo "摄像头测试类";
        $returnData = M('camera')->selectSomeInfo();

        //var_dump(file_get_contents('configs/nowAlgorithm.conf'));
       // var_dump( M('algorithm')->getKeyword($returnData[0]['area']) );

        //判断 文件中的与列表中的是否是否为 同一种算法
       /* if ( file_get_contents('configs/nowAlgorithm.conf') !=  M('algorithm')->getKeyword($returnData[0]['area']) ){
            file_put_contents('configs/nowAlgorithm.conf', M('algorithm')->getKeyword($returnData[0]['area']) );
        }*/


        //selectName

        SmartyChild::getSmarty()->assign('camera',$returnData);
        SmartyChild::getSmarty()->display(CAMERA_URI);
    }

    public function cameraList(){
//        echo "摄像头测试类";
        $returnData = M('camera')->getAllCameraInfo();
        //var_dump($returnData[0]);
       /* if ( file_get_contents('configs/nowAlgorithm.conf') !=  M('algorithm')->getKeyword($returnData[0]['area']) ){
            file_put_contents('configs/nowAlgorithm.conf', M('algorithm')->getKeyword($returnData[0]['area']) );
        }*/
       // echo '<hr />';
        $returnData2 =  M('algorithm')->selectName();
        //var_dump($returnData2);



        SmartyChild::getSmarty()->assign('algorithmName',$returnData2);

        SmartyChild::getSmarty()->assign('camera',$returnData);
        SmartyChild::getSmarty()->display(CAMERA_LIST_URI);
    }

    public function del(){
       // var_dump($_GET['id']);
        $returnData = M('camera')->delete($_GET['id']);

        if($returnData==1){
        $this->cameraList();
        }else{
            die("删除错误");
        }
    }

    public function update(){
        //var_dump($_POST);
        $returnData = M('camera')->update($_POST);
       // var_dump($returnData);
        if($returnData==1){
            $this->cameraList();
        }else{
            die("修改失败");
        }

    }
    /*
     * 添加摄像头，还需要添加 定时任务，判定文件
     *
     * 判定时间的时候，为空则不添加定时任务
     * */

    public function add(){
        if($_POST['start_Timer'] == '' || $_POST['start_Timer'] == ''){
           //没有定制 算法时间 直接进行文件的保存
        }else{
            //定制了 算法的时间，此处需要 增加定时器任务
            //1.添加 事件到  定时器任务中

            //

        }
        var_dump($_POST);


        die();
        $returnData = M('camera')->insert($_POST);
        //var_dump($returnData);
        if($returnData==1){
            $this->cameraList();
        }else{
            die("修改失败");
        }
    }


    public function test(){


    }





}