<?php

/**
 * Created by PhpStorm.
 * User: woodenwang
 * Date: 2019/10/16
 * Time: 10:44
 *
 * 报警管理
 */
class AlertController
{

    public function alertList(){
       // echo "报警列表";
        $returnData =  M('alert')->selectAll();
        $returnData2 =  M('algorithm')->selectName();
       // var_dump($returnData2);

        SmartyChild::getSmarty()->assign('algorithmName',$returnData2);

        SmartyChild::getSmarty()->assign('alert',$returnData);
        SmartyChild::getSmarty()->display(ALERT_LIST_URI);
    }

    public function del(){
        // var_dump($_GET['Id']);
        $returnData = M('alert')->delete($_GET['id']);

        if($returnData==1){
            $this->alertList();
        }else{
            die("删除错误");
        }
    }

    public function update(){
      /* var_dump($_POST);
        die();*/
        $returnData = M('alert')->update($_POST);
        // var_dump($returnData);
        if($returnData==1){
            $this->alertList();
        }else{
            die("修改失败");
        }

    }
    public function add(){
        //var_dump($_POST);
        $returnData = M('alert')->insert($_POST);
        //var_dump($returnData);
        if($returnData==1){
            $this->alertList();
        }else{
            die("修改失败");
        }
    }


}

