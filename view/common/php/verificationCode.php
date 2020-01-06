<?php
/**
 * Created by PhpStorm.
 * User: WoodenWang
 * Date: 2017/10/29
 * Time: 16:17
 */
header("content-type:image/png");
$code=imagecreatetruecolor(100,30);
$red=imagecolorallocate($code,0xff,0x00,0x00);
$green=imagecolorallocate($code,0x00,0xff,0x00);
$blue=imagecolorallocate($code,0x00,0x00,0xff);
$black=imagecolorallocate($code,0x00,0x00,0x00);
$backColor = imagecolorallocate($code, 0xd9,0xd9,0xf3);
$arrColor=array("$red","$green","$blue","$black");
$arrNum=array(
    "character"=>array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z"),
    "number"=>array("1","2","3","4","5","6","7","8","9","0")
);

imagefill($code,0,0,$backColor );/////索引到数组的位置array_rand($arrColor,1)

/*干扰线*/
for($i=0;$i<30;$i++){
    imageline($code,rand(0,100),rand(0,30),rand(0,100),rand(0,30),$arrColor[array_rand($arrColor,1)]);
}
///////干扰点
for($i=0;$i<rand(500,600);$i++){
    imagesetpixel($code,rand(0,500),rand(0,500),$arrColor[array_rand($arrColor,1)]);
    imagesetpixel($code,rand(0,500),rand(0,500),$arrColor[array_rand($arrColor,1)]);
}
/*数字*/
$num="";
for($i=0;$i<rand(4,6);$i++){
    //$num.=dechex(rand(0,9));

    if(rand(0,10)<5){
        $num.=dechex(rand(0,9));
    }else{
        $num.=$arrNum["character"][array_rand($arrNum["character"],1)];
    }
}
//setcookie("loginNum",$num,time()+3600);
session_start();
$_SESSION["verifcationCode"]=$num;
//imagestring($code,7,rand(0,30),rand(0,10),$num,$arrColor[array_rand($arrColor,1)]);
$fontFile="bold.ttf";
imagettftext($code, 18, rand(0,1), 10, 20, $arrColor[array_rand($arrColor,1)], $fontFile, $num);
imagepng($code);
imagedestroy($code);


/*颜色的使用上，吧文字的与背景的区别*/