<?php
/**
 * Created by PhpStorm.
 * User: WoodenWang
 * Date: 2017/11/17
 * Time: 20:30
 */
header("Content-type:text/html;charset=utf8");
//require "model/User.php";
//require "model/Shop.php";
//require "controller/User.php";
//require "controller/Shop.php";
//$c=$_GET["c"];
//$a=$_GET["a"];
//
//$user=new $c();
//$user->$a();
//require 'configs/test.php';
require "configs/url.conf.php";
//require "configs/indexMenu.conf.php";
require "configs/adminMenu.conf.php";
require "configs/db.conf.php";
require "smarty/Smarty.class.php";
require "common/SmartyChild.php";
require "common/function.php";
//require "common/MongoConnect.php";
require "common/MysqlDB.class.php";
require "common/common.php";
require 'vendor/autoload.php';
C();
