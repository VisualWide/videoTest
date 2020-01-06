<?php

// 应用公共文件
/**
 * 返回数据格式
 * /////////////////////////
 * 协议：
 * 100 C层操作成功（处理层）
 * 200 V层操作成功（显示层）
 *
 * 300 M层操作成功（数据层）
 * 400 C层操作失败
 * 500 V层操作失败
 *      501 验证码错误
 *      502 用户名密码错误
 *
 *      510 用户长时间未操作
 * 600 M层操作失败
 *
 * @param int $code ,编号
 * @param  string $data ,内容
 * @return array
 */

function returnData($code, $data){
    return array(
        "code"=>$code,
        "data"=>$data
    );
}

/**
 *  判断字符串长度的函数
 * @param string  $str,输入目标字符串
 * @param int $len,数据标准长度
 * @return string   返回结果
 */
function judgeLen($str, $len){
    $allLength=mb_strlen($str,'utf-8');
    if($allLength<$len){
        return returnData(0,"长度过长");
    }else if($allLength>$len){
        return returnData(1,"长度过短");
    }else{
        return "长度相等";
    }
}

/**
 * 判断输入变量的类型
 * @param string $someOne,输入的变量
 * @return string   返回类型
 */
function judgeType($someOne){
    if(is_scalar($someOne)){        //是否是标量
        if(is_int($someOne)){       //是否是整形
            return "整型";
        }else if(is_string($someOne)){      //是否是字符串
            if(is_numeric($someOne)){       //是否是字符串类型数字
                return "字符串类型的数字";
            }else{
                return "字符串";
            }
        }else if(is_bool($someOne)){        //是否是布尔类型
            return "布尔类型";
        }else if(is_float($someOne)){       //是否是浮点类型
            return isInfinite($someOne)."浮点数";

        }else if(is_double($someOne)){      //是否是双精度浮点类型

            return isInfinite($someOne)."双精度浮点型";
        }
    }else{
        if(is_array($someOne)){     //数组
            return "数组";
        }else if(is_object($someOne)){      //是否是对象
            return "对象";
        }else if(is_resource($someOne)){        //是否是资源句柄
            return "资源函数";
        }
    }
}
/**
 * 判断是否是无限值
 * @param $num  输入浮点数
 * @return string   返回类型
 */
function isInfinite($num){
    if(is_infinite($num)){
        return "有限值";
    }else{
        return "无限值";
    }
}

/**
 *  函数的调用方法，存在返回函数调用方法。
 * @param $funName  string,函数名字
 * @return mixed    调用方法
 */
function konwFunction($funName){
    if(is_callable($funName,false,$returnName)){
        return $returnName;
    }else{
        return "不可调用该函数";
    }
}

/**
 *  文件信息判断
 * @param $file string,文件路径名
 */
function fileInfo($file){
    if(is_dir($file)){
        if(is_dir($file)!=true){
            echo is_dir($file)."/t";
        }else{
            echo "文件名存在"."/t";
        }
    }
    if(is_file($file)){
        echo    "此文件存在/t";
        return FileERW($file);
    }else{
        echo    "此文件不存在/t";
    }
}


/**
 * 文件可操作状态判断
 * @param $file
 */
function FileERW($file){
    if(is_executable($file)){
        echo    "可执行/t";
    }else{
        echo    "不可执行/t";
    }
    if(is_readable($file)){
        echo    "可读取/t";
    }else{
        echo    "不可读取/t";
    }
    if(is_writeable($file)){
        echo    "可写入/t";
    }else{
        echo    "不可写入/t";
    }
}

/**
 * 文件是否是POST传输
 * @param $file string,文件路径名
 * @return string
 */
function  isPost($file){
    if(is_uploaded_file($file)){
        return "通过HTTP POST传输/t";
    }else{
        return "并未通过HTTP POST传输，谨慎使用/t";
    }
}
//数据加密：
/**
 * 对数据单向加密s
 * @param  string $someOne  传入数据
 * @return string   加密数据
 */
function changePasswordType($someOne){
    $someOne=md5($someOne);     //先进行md5加密
    $salt=mb_substr($someOne,strlen($someOne)-4,strlen($someOne)-2);//截取上面的倒数第四位到第二位
//    $endpwd=crypt($someOne,$salt);  //crypt加盐加密盐值为以上字符
//    $endpwd=sha1($endpwd);     //在经过一次sha1加密
//    $endpwd=md5($endpwd);   //最后在经行一次MD5加密
    $endpwd=md5(sha1(crypt($someOne,$salt)));   //综合以上
    return $endpwd;
}

/**
 * 解码路径
 * @param $url  需要解码路径
 * @return string   返回解码路径
 */
function urlTodecode($url){
    $url=urldecode($url);
    return $url;
}

/**
 *
 * 把图片的地址信息转换为数据样式
 * @param $imgUrl   图片路径
 * @return string   返回的数据
 */
function changeImg($imgUrl){
    $res=file_get_contents($imgUrl);
    $imgData=base64_encode($res);
    return $imgData;
}
//数据库检验
/**
 * 管理员表入库测试
 * @param $id
 * @param $admin
 * @param $password
 * @return array
 */
function intoAdmin($id, $admin, $password){
    $flag1= judgeType($id)=="整型";
    $flag2= judgeType($admin)=="整型";
    $flag3= judgeType($password)=="整型";
    if($flag1&&$flag2&&$flag3){
        return returnData(0,"管理员库数据入库类型正确");
    }else{
        return returnData(1,"管理员库数据入库类型错误");
    }
}
////////////需要用的时候单个验证

//入库前价格的格式化
/**
 * 将浮点数转保留小数点后两位
 * @param $price
 * @return string
 */
function intoDbNumeric($price){
    $format_num = sprintf("%.2f",$price);
    return $format_num;
}


/**
 * 重定向地址
 * @param $url
 * @param int $time
 * @param string $msg
 */
function redirect($url, $time=0, $msg='') {
//多行URL地址支持
    $url = str_replace(array("\n", "\r"), '', $url);
    if (empty($msg))
  //  $msg = "系统将在{$time}秒之后自动跳转到{$url}！";
    if (!headers_sent()) { //如果标头没有发出
    // redirect
    if (0 === $time) {
        header('Location: ' . $url); //如果没有指定延时时间，则发一个跳转标头
    } else {
        header("refresh:{$time};url={$url}");//如果制定了延时时间，则发一个延时刷新的标头
            echo($msg);
        }
        exit();
    } else { //否则就发送 meta 标记，含义同上
        $str = "<meta http-equiv='Refresh' content='{$time};URL={$url}'>";
        if ($time != 0)
        $str .= $msg;
        exit($str);
    }
}


/**
 * 删除路由
 * @param $arr
 * @return mixed
 */
function delRoute($arr){

    array_shift($arr);
    array_shift($arr);
    return $arr;
}

/**
 * @param $arr  编号and提醒
 */
function alert($arr){

    echo "<script>alert('提示编号:".$arr['code'].";提示信息:".$arr['data']."')</script>";
}

/**
 * 此乃解析mongo返回数据的方法
 * @param $cursor   mongo返回信息
 * @return array    解析后数据
 */
function mongoParseToArr($cursor){
    $arr=array();
    foreach($cursor as $document){
        foreach($document as $key=>$value ) {
                //echo $key,"====>",$value;
                $arr=array_merge($arr,array($key=>$value));
                //echo '<hr />';
        }
    }
    return $arr;
}
/**
 * 读取CSV文件
 * @param string $csv_file csv文件路径
 * @param int $lines       读取行数
 * @param int $offset      起始行数
 * @return array|bool
 */
function read_csv_lines($csv_file = '', $lines = 0, $offset = 0)
{
    if (!$fp = fopen($csv_file, 'r')) {
        return false;
    }
    $i = $j = 0;
    while (false !== ($line = fgets($fp))) {
        if ($i++ < $offset) {
            continue;
        }
        break;
    }
    $data = array();
    while (($j++ < $lines) && !feof($fp)) {
        $data[] = fgetcsv($fp);
    }
    fclose($fp);
    return $data;
}


/**
 * 写入csv文件
 * @param array  $csv_header csv文件表头
 * @param array  $csv_body  csv内容
 * @param array  $des_file  csv目标地址
 */
function create_csv($csv_header, $csv_body, $des_file)
{
    /**
     * 开始生成
     * 1. 首先将数组拆分成以逗号（注意需要英文）分割的字符串
     * 2. 然后加上每行的换行符号，这里建议直接使用PHP的预定义
     * 常量PHP_EOL
     * 3. 最后写入文件
     */
// 打开文件资源，不存在则创建
    $fp = fopen(    $des_file,'a');
// 处理头部标题
    $header = implode(',', $csv_header) . PHP_EOL;
// 处理内容
    $content = '';
    foreach ($csv_body as $k => $v) {
        $content .= implode(',', $v) . PHP_EOL;
    }
// 拼接
    $csv = $header.$content;
// 写入并关闭资源
    fwrite($fp, $csv);
    fclose($fp);
}





/**
 * 告警显示
 *  20191008 need 类型/坐标/时间。
 * @param $arr
 */
function alertSomeWring($arr){

    echo "
    <script src='view/common/js/jquery.min.js?v=2.1.4'></script>
    <script src='view/common/js/plugins/layer/layer.min.js'></script>
    <script> layer.msg('".$arr['type']."', { offset: 't', anim: 6}); </script>
    ";
}
