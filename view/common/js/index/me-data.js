//性别点击事件,划出性别选项
$(".Sex").click(function(){
	$(".sxcPop").animate({
		bottom:"0px"
	},500)
	$(".Masked").css("display","block")
	
})
var Option=document.getElementsByClassName("Option")[0];
var induOption=document.getElementsByClassName("induOption")[0];
Option.addEventListener('touchmove',chmoveFun,false);    
Option.addEventListener('touchstart',chstartFun,false);   
Option.addEventListener('touchend',chendFun,false);
induOption.addEventListener('touchmove',chmoveFun,false);    
induOption.addEventListener('touchstart',chstartFun,false);   
induOption.addEventListener('touchend',chendFun,false);
var chstarY;  //触摸时的y坐标
var mobile; //男女div需要移动的距离
var jumobile=false;  //判断是否第一次发生触摸移动
var _mobile=0;  //记录非第一次移动的距离总和
//触摸时函数
function chstartFun(e){
	e.preventDefault()
	chstarY=e.changedTouches[0].pageY;
}
//移动时发生
function chmoveFun(e){
	e.preventDefault()
	var startY=e.changedTouches[0].pageY;   //获取移动时y坐标
	mobile=chstarY-startY
	
	//性别选项
	$(".male").css("paddingTop",110-mobile+"px");
	//行业选项
//	$(".won").css("paddingTop",110-mobile+"px");
//	console.log(100-mobile)
	if(jumobile==false){
		$(".won").css("paddingTop",110-mobile+"px");
	}else{
		$(".won").css("paddingTop",(_mobile-mobile+"px"));
//		console.log(mobile+_mobile)
	}
	
}
//移开时发生
function chendFun(e){
	e.preventDefault()
	_mobile=mobile;
	console.log(_mobile)
	console.log(mobile)
	jumobile=true;
	if(mobile>0){
		$(".male").css("paddingTop","76px")
	}else{
		$(".male").css("paddingTop","110px")
	}
}
//性别取消
$(".determine .left").click(function(){
	Todrawout();
})
//性别确定
$(".determine .right").click(function(){
	Todrawout();
	if(mobile>=0){
		$(".Sex span").html("女")
	}else{
		$(".Sex span").html("男")
	}
	console.log(mobile)
})
function Todrawout(){
	$(".sxcPop").animate({
		bottom:"-270px"
	},500)
	$(".Masked").css("display","none");
}