//给第一导航第一个添加默认样式
$(".child").css("border-top","1px solid #FD634F");
//给选项卡添加样式
$(".heda-nav li").click(function(){
	$(".heda-nav li").css("border-top","1px solid #ccc");
	$(".heda-nav li").css("color","#3C4347")
	$(this).css("border-top","1px solid #FD634F");
	$(this).css("color","#FD634F");
	$(".Outer").css("display","none");
	switch ($(this).html()){
		case "推荐":
			$(".Recommend").css("display","block");
			break;
		case "国考":
			$(".Ncse").css("display","block");
			break;
		case "省考":
			$(".Pe").css("display","block");
			break;
		case "门类":
			$(".category").css("display","block");
			break;
		case "闲聊":
			$(".Gossip").css("display","block");
			break;
	}
});
//点击选项卡显示对应的div 并且隐藏其他div

//轮播图片
Qfast.add('widgets', { path: "view/common/js/index/terminator2.2.min.js", type: "js", requires: ['fx'] });
Qfast(false, 'widgets', function () {
	K.tabs({
		id: 'fsD1',   //轮播图包裹id  
		conId: "D1pic1",  //** 大图域包裹id  
		tabId:"D1fBt",  
		tabTn:"a",
		conCn: '.fcon', //** 大图域配置class       
		auto: 1,   //自动播放 1或0
		effect: 'fade',   //效果配置
		eType: 'click', //** 鼠标事件
		pageBt:true,//是否有按钮切换页码
		bns: ['.prev', '.next'],//** 前后按钮配置class                          
		interval: 3000  //** 停顿时间  
	}) 
})  

//侦听滚动条大于650显示返回顶部按钮
$(window).scroll(
	function(){
		var scrollTop=$(window).scrollTop();  //滚动条滚动的高度
		if(scrollTop>650){
			$(".Return-top").css("display","block")
		}else{
			$(".Return-top").css("display","none")
		}
		
	}
)
//当点击返回顶部按钮 滑到顶部
$(".Return-top").click(function(){
    var speed=200;//滑动的速度
    $('body,html').animate({ scrollTop: 0 }, speed);
    return false;
})

//从缓存中读取到商品总数量
var Number2=localStorage.getItem("Number"); 
$(".nav-d span").html(Number2);
var arr=[];  //缓存数组
var meatDIVNumber=1;  //加入购物车单个商品的数量
var commodity=localStorage.getItem("commodity");    //读取当前已经存在的缓存
var _commodity=JSON.parse(commodity);  //解析josn格式
//点击购物车显示成功加入购物车div
$(".Shopping").click(function(){
	$(".Cartjoin p").fadeIn(1000,function(){
		$(".Cartjoin p").fadeOut(1000)
	})
	//点击商品购物车图标，购物车值加1
	var Number1=Number($(".nav-d span").html())
	Number1++;
	$(".nav-d span").html(Number1);
	//购物车缓存
	var meatDIV=$(this).closest(".meatDIV ");  //父层级div
	var meatDIVImg=meatDIV.find("img").attr("src");  //商品图片
	var meatDIVName=meatDIV.find("h2").html();   //商品名称
	var meatDIVPrice=meatDIV.find("i").html();  //商品价格
	var obj={
		img:meatDIVImg,
		name:meatDIVName,
		price:meatDIVPrice,
		Number:meatDIVNumber
	}
	arr.push(obj);
	var _arr=JSON.stringify(arr);  //转成josn格式
	localStorage.setItem("commodity",_arr);   //存储缓存
	localPlus(meatDIVName);
})

if(commodity !=null){
	for(var i=0;i<_commodity.length;i++){
		arr.push(_commodity[i]);
	}
}

function localPlus(meatDIVName){
	var commodity=localStorage.getItem("commodity");    //读取当前已经存在的缓存
	var _commodity=JSON.parse(commodity);  //解析josn格式
	//判断点击之前缓存是否为空
	if(commodity !=null){
		for(var i=0;i<_commodity.length;i++){
			if(_commodity[i].name==meatDIVName){
				_commodity.splice(i,1)
				meatDIVNumber++;
			}
		}
	}
}











//导航触摸滑动
var nav = document.getElementById('heda-nav');
var chstartX;  //记录触摸的x坐标
var chendX;  //记录移开时X坐标
var move;  //导航移动的距离
var move1;
var move2=0;    //记录导航往右侧的值
var juOneSlide=false;   //判断是否是第一次向右侧滑动
var width=window.screen.width;    //获取页面宽度
var navWidth=(width*0.22)*7;   //总共导航宽度
var liWidth=width*0.22;  //每个li的宽度
//nav.addEventListener('touchstart',chstartFun,false);
//nav.addEventListener('touchmove',chmoveFun,false);
//nav.addEventListener('touchend',chendFun,false);
//触摸时发生
function chstartFun(e){
	var touch = e.targetTouches[0];
    chstartX=touch.pageX;
    console.log("按下"+chstartX)
}
var id;
var id1;
 //移开时发生
function chendFun(e){
	var touch=e.changedTouches[0];
    chendX=touch.pageX;
    if(move>0){
    	id=setInterval(IntervalFun,1);
    }
    if(-move>navWidth-width){
    	id1=setInterval(EndFun,1);
    }
    juOneSlide=true;
    //让每次往右侧移动的值累加
    move1=chendX-chstartX;
    move2+=move1;
}
//失去触摸点时导航滑到起始点
function IntervalFun(){
	if(move>0){
		move--;
	   	$(".heda-nav").css("transform","translate3d("+move+"px, 0px, 0px)");
	}else{
		//执行完清除一次计时器
		clearTimeout(id);
	}
}

function EndFun(){
	if(-move>navWidth-width){
		move++;
	   	$(".heda-nav").css("transform","translate3d("+move+"px, 0px, 0px)");
	}else{
		//执行完清除一次计时器
		clearTimeout(id1);
	}
}

//移动时发生
function chmoveFun(e){
     // 如果这个元素的位置内只有一个手指的话
    if (e.targetTouches.length == 1) {
　　　　 e.preventDefault();   //阻止浏览器默认事件，重要 
        var touch = e.targetTouches[0];
		//把元素放在手指所在的位置
        startX=touch.pageX;
        //第一次划动
        if(juOneSlide==false){
        	//触摸x坐标减去移动x坐标
	        move=startX-chstartX;
        }else{
        	//往左滑动进入
        	if(move>=0){
        		move=startX-chstartX;
        		juOneSlide=false;
    		//往右滑动进入
        	}else{
        		move=move2+(startX-chstartX);
        	}
        }
       	$(".heda-nav").css("transform","translate3d("+move+"px, 0px, 0px)");
     }
}
