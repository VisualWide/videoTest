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
 * */


class IndexController
{
    public function index(){

        $returnData = M('camera')->selectSomeInfo();
        SmartyChild::getSmarty()->assign('camera',$returnData);
        //var_dump( $returnData );
        SmartyChild::getSmarty()->display(INDEX_URI);
    }


    public function test(){
        $returnData = M('camera')->selectSomeInfo();
        SmartyChild::getSmarty()->assign('camera',$returnData);

        SmartyChild::getSmarty()->display('view/index/index.html');
    }

    //
    public function changeAIStatus(){

        //1.将当前算法得flag改变为False
        $after = $_POST['after'];
        //file_put_contents('/home/vw/src/gjsj/detector/conf/'.$after.'.flag',False)
        //2.将需要修改的flag改变未True
        $now = $_POST['now'];
        //file_put_contents('/home/vw/src/gjsj/detector/conf/'.$now.'.flag',False)

    }

    /**
     *这是错误页面
     */
    public function error(){
        SmartyChild::getSmarty()->display(ERROR_404);
    }
}
