var jsurl=new Array();
jsurl.push("http://js.ue.766.com/jsfan/tab/tab.js");  //0
jsurl.push("http://js.ue.766.com/jsfan/tab/tab_img.js");//1
jsurl.push("http://js.ue.766.com/jsfan/tip/tooltip.js");//2

jsurl.push("http://js.ue.766.com/jsfan/dropdownmenu/menus.js");//3
jsurl.push("http://js.ue.766.com/jsfan/dropdownmenu/bgpos.js");//4

jsurl.push("http://js.ue.766.com/jsfan/scrolling_img/scrolling_img.js");//5

jsurl.push("http://js.ue.766.com/jsfan/scrolling_text/scrolling_text.js");//6
jsurl.push("http://js.ue.766.com/jsfan/scrolling_text/list_text.js");//7

jsurl.push("http://js.ue.766.com/jsfan/slide/slide.js");//8
jsurl.push("http://js.ue.766.com/jsfan/slide/slide2.js");//9
jsurl.push("http://js.ue.766.com/jsfan/slide/slide4.js");//10
jsurl.push("http://js.ue.766.com/jsfan/slide/slide3.js");//11

jsurl.push("http://js.ue.766.com/jsfan/tab/show_obj.js");//12

jsurl.push("http://js.ue.766.com/jsfan/load/lazyload.js");//13

jsurl.push("http://js.ue.766.com/jsfan/backToTop/back_top.js");//14

var scl="<script src='";
var scr="'></script>";
var callobj=function(ay){
	jQuery.each(ay,function(i,n){
		document.write(scl+jsurl[n]+scr);		   
	});
};
