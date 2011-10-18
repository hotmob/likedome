/* JS Document 
Version:	1.0
Date:		2010/10/16
Author:		XX
Update:
*/
(function($){
	//图片加载
	$.after_img=function(obj){
		var defname="imgsrc";	  
		$(obj).each(function(i){
			if($(obj).eq(i).attr("src")=="" || $(obj).eq(i).attr("src")=="http://img.ue.766.com/common/blank.gif" )
			{
				if(!$(obj).eq(i).attr(defname))return;
				$(obj).eq(i).attr("src",$(obj).eq(i).attr(defname));	
			}
		});
	};
	$.fn.after_img=function(){
		new $.after_img($(this));
		return this;
	};
	//切换菜单
	$.tab=function(obj1,obj2,iBeHavior,fun){
		var _timer;
		var last=0;
		obj2.find("img").each(function(i,j){
			if($(j).attr("src")=="")$(j).attr("src","http://img.ue.766.com/common/blank.gif");
		});
		obj2.eq(0).show();
		obj2.eq(0).find("img").after_img();
		obj1.each(function(i){
			showD=function(){
				obj1.attr("class"," ");
				obj1.eq(i).attr("class","select");
				obj2.hide();
				obj2.eq(i).show();
				obj2.eq(i).find("img").after_img();
				if(fun)eval("fun(obj1.eq("+i+"),obj2.eq("+i+"))");
			}
			eval("$(this)."+iBeHavior+"("+showD+")");
		});
	};
	$.fn.tab=function(iBeHavior,fun){
		var iBeHavior = iBeHavior || 'click';
		var obj1=$(this).find(".tab_menu li");
		var obj2=$(this).find(".tab_main");
		new $.tab(obj1,obj2,iBeHavior,fun);
		return this;
	};
})(jQuery);
/*
使用方法：
$("#test1").tab("click");
“#test1”即是对象的ID。里面的参数也可以写对象的className，写法跟CSS一样，即“.test1”。
Html代码的基本结构式：
	<div id="test1">    //这里的id跟“$("#test1").tab();”里面的id是想对应的
		<ul class="tab_menu">  //里面的class名是固定的
			<li class="select">分类1</li>
			<li>分类2</li>
			<li>分类3</li>
		</ul>
		<div class="tab_main">内容1<img src="" imgsrc="图片地址"/></div>
		<div class="tab_main">内容2</div>
		<div class="tab_main">内容3</div>
	</div>
*/