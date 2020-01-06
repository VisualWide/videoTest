<?php

/**
 * Created by PhpStorm.
 * User: woodenwang
 * Date: 2019/10/16
 * Time: 10:50
 *
 * 算法接口
 *
 */
class AlgorithmController
{
    public function algorithmList(){
        //echo "算法列表";
        $returnData =  M('algorithm')->selectAll();
        //var_dump($returnData);

        SmartyChild::getSmarty()->assign('algorithm',$returnData);
        SmartyChild::getSmarty()->display(ALGORITHM_LIST_URI);
    }

    public function algorithmSomeOne(){
        echo "算法关联";
    }

    public function del(){
        // var_dump($_GET['id']);
        $returnData = M('algorithm')->delete($_GET['id']);

        if($returnData==1){
            $this->algorithmList();
        }else{
            die("删除错误");
        }
    }

    public function update(){
        //var_dump($_POST);
        $returnData = M('algorithm')->update($_POST);
        // var_dump($returnData);
        if($returnData==1){
            $this->algorithmList();
        }else{
            die("修改失败");
        }

    }
    public function add(){
        //var_dump($_POST);

        $returnData = M('algorithm')->insert($_POST);
        //var_dump($returnData);
        if($returnData==1){
            $this->algorithmList();
        }else{
            die("修改失败");
        }
    }

    public function test(){

    }



}