<?php
/**
 * Created by PhpStorm.
 * User: WoodenWang
 * Date: 2017/11/17
 * Time: 22:50
 */

function C(){
    $c=isset($_GET["c"])?$_GET["c"]:"index";  //user
    $a=isset($_GET["a"])?$_GET["a"]:"index";
    $c=ucfirst($c);
    if(!file_exists("controller/$c.php")){
        header("Location:".ERROR404_URL);
    }
    require "controller/$c.php";

    $className=$c."Controller";
    $user=new $className();
    if(!method_exists($className,$a)){
        header("Location:".ERROR404_URL);
    }
    $user->$a();
}

/**
 * 此乃数据库调用方法
 * @param string $_type    模型的名称
 * @param null $_var    表，集合的名称
 * @return mixed
 */
function M($_type, $_var=null){
    $_type=ucfirst($_type);
    require_once "model/$_type.php";
    $className=$_type."Model";

    $some= $_var==null?new $className():new $className($_var);
    return $some;
}

