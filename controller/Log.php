<?php
/**
 * Created by PhpStorm.
 * User: woodenwang
 * Date: 2019/8/29
 * Time: 16:07
 *
 *
 * 日志操作
 */

class LogController
{
    public function index(){
//        echo "日志信息","<br />";

        $returnData = M('log')->getList();
        // var_dump($returnData);
        $returnData2 =  M('algorithm')->selectName();
        // var_dump($returnData2);
        //selectName
        $returnData3 =  M('camera')->selectName();
        // var_dump( $returnData3 );
        SmartyChild::getSmarty()->assign('cameraName',$returnData3);

        SmartyChild::getSmarty()->assign('algorithmName',$returnData2);
        SmartyChild::getSmarty()->assign('logList',$returnData);

        SmartyChild::getSmarty()->display(LOG_LIST_URI);
    }

    public function repertoire(){
        $returnData = M('log')->getList();
        // var_dump($returnData);
        $returnData2 =  M('algorithm')->selectName();
        // var_dump($returnData2);
        //selectName
        $returnData3 =  M('camera')->selectName();
       // var_dump( $returnData3 );
        SmartyChild::getSmarty()->assign('cameraName',$returnData3);

        SmartyChild::getSmarty()->assign('algorithmName',$returnData2);
        SmartyChild::getSmarty()->assign('logList',$returnData);


        SmartyChild::getSmarty()->display('view/admin/log/list.html');
    }



    public function changeLogResults(){
        $_id = $_GET['id'];
       $returnData =  M('log')->changeStatus($_id);
        if($returnData == 1){
            echo json_encode("成功",JSON_UNESCAPED_UNICODE);
        }else{
            echo json_encode("失败",JSON_UNESCAPED_UNICODE);
        }
    }
    public function nowDay(){
        $returnData = M('log')->selectNowDay();
         // var_dump($returnData);

        $returnData2 =  M('algorithm')->selectName();
        // var_dump($returnData2);
        SmartyChild::getSmarty()->assign('algorithmName',$returnData2);
        SmartyChild::getSmarty()->assign('logList',$returnData);
        SmartyChild::getSmarty()->display(LOG_LIST_URI);

    }
    public function nowWeek(){
        $returnData = M('log')->selectNowWeek();
        $returnData2 =  M('algorithm')->selectName();
        // var_dump($returnData2);
        SmartyChild::getSmarty()->assign('algorithmName',$returnData2);
        SmartyChild::getSmarty()->assign('logList',$returnData);
        SmartyChild::getSmarty()->display(LOG_LIST_URI);
    }
    public function nowMonth(){
        $returnData = M('log')->selectNowMonth();
        $returnData2 =  M('algorithm')->selectName();
        // var_dump($returnData2);
        SmartyChild::getSmarty()->assign('algorithmName',$returnData2);
        SmartyChild::getSmarty()->assign('logList',$returnData);
        SmartyChild::getSmarty()->display(LOG_LIST_URI);
    }

    public function changeType(){
       // var_dump($_GET['id']);
        $_type = '';
        switch ($_GET['id'] ){
            case '1':
                $_type = '未穿工服进入';
                break;
            case '2':
                $_type = '未佩戴安全帽';
                break;
            case '3':
                $_type = '违规吸烟';
                break;
            case '4':
                $_type = '违规打电话';
                break;
            case '5':
                $_type = '火灾报警';
                break;
            case '6':
                $_type = '烟雾报警';
                break;
            case '7':
                $_type = '危险区闯入';
                break;
            default:
                break;
        }

        $returnData = M('log')->selectSomeType($_type);
        $returnData2 =  M('algorithm')->selectName();
        // var_dump($returnData2);
        SmartyChild::getSmarty()->assign('algorithmName',$returnData2);
        SmartyChild::getSmarty()->assign('logList',$returnData);
        SmartyChild::getSmarty()->display(LOG_LIST_URI);
    }
    public $waringType = array(
        '未穿工服进入',
        '未佩戴安全帽',
        '违规吸烟',
        '违规打电话',
        '火灾报警',
        '烟雾报警',
        '危险区闯入'
    );

    public function returnWaringContent( ){
    //var_dump($this->waringType[1]);

        if (strpos($_GET['id'],'0') !== false){
            echo json_encode( M('log')->getLogList());
        }else{

            $arr = str_split( $_GET['id'] );
            $sql_slice = " warning_type = '347269285' ";
            foreach($arr as $key =>$value){
                $sql_slice .="OR warning_type = '".$this->waringType[$value-1]."' ";
            }
            echo json_encode( M('log')->selectMoreType($sql_slice));
        }

    }


    public function searchSomeOne(){

        var_dump(json_encode( $_POST ));

    }


}