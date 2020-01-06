<?php

/**
 * Created by PhpStorm.
 * User: woodenwang
 * Date: 2019/11/10
 * Time: 11:07
 */
class confController
{

    /*    Mysql_conf = { 'host' : '58.87.97.190', 'user' : 'root', 'pwd' : 'WangLin123!Run', 'databases' : 'vod' }
     *
     *
     *
     * */

    public function index(){
        //echo 'conf';

        $mysqlConf = $this->getFileContents(MYSQL_CONF_URI);
        $rtspConf = $this->getFileContents(RTSP_CONF_URI);



        SmartyChild::getSmarty()->assign('rtspConf',$rtspConf);

        SmartyChild::getSmarty()->assign('mysqlConf',$mysqlConf);



        SmartyChild::getSmarty()->display(CONF_URI);

    }
    /*
     * ["db_host"]=> string(12) "58.87.97.190" ["db_user"]=> string(4) "root" ["db_pwd"]=> string(14) "WangLin123!Run" ["db_database"]=> string(3) "vod"
     *
     * */

    public function update(){
        var_dump($_POST);
        switch($_POST['conf_type']){
            case 'mysql':
                $_content = "Mysql_conf = { 'host' : '".$_POST['db_host']."', 'user' : '".$_POST['db_user']."', 'pwd' : '".$_POST['db_pwd']."', 'databases' : '".$_POST['db_database']."' }";
                $flag = file_put_contents(MYSQL_CONF_URI,$_content);
                break;
            case 'rtsp':
                $_content = "Rtsp_conf = { 'ip' : '".$_POST['rtsp_ip']."', 'user' : '".$_POST['rtsp_user']."', 'pwd' : '".$_POST['rtsp_pwd']."', 'stream_type' : '".$_POST['rtsp_stream_type']."' }";
                $flag = file_put_contents(RTSP_CONF_URI,$_content);
                break;
        }

        redirect('?c=conf&a=index');
    }

    private function getFileContents($file_rui){
        $need_preg = file_get_contents( $file_rui ) ;
        $ms = "/ = /";
        $serverContent = preg_split($ms,$need_preg)[1] ;
        $pattern ="#'(.*?)'#i";
        preg_match_all($pattern, $serverContent, $pregContent);
        return $pregContent[1];

    }


}