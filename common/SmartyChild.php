<?php
/**
 * Created by PhpStorm.
 * User: WoodenWang
 * Date: 2017/11/21
 * Time: 18:22
 */
class SmartyChild extends Smarty{
    public function __construct()
    {
        $this->template_dir='/templates/';
        $this->compile_dir='/templates_c/';
        $this->cache_dir='/cache/';
        $this->config_dir='/configs/';

        $this->allow_php_tag=true;
    }
    private static $isSmarty=null;
    public static function getSmarty(){
        if(!self::$isSmarty){
            self::$isSmarty=new Smarty();
        }
        return self::$isSmarty;
    }

}