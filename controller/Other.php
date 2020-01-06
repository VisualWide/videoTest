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


class OtherController
{
   
    public function startServer(){
       
        exec( 'python wl.py ' , $output );
        
        var_dump($output);
    }
    
    public function stopServer(){
         return alert(returnData(666,'server is stop !!!'));
        
    }
    
    
}