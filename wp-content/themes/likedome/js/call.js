var jsurl=new Array();
jsurl.push("wp-content/themes/Likedome/js/jsfan/tab/tab.js");  //0
jsurl.push("wp-content/themes/Likedome/js/jsfan/tab/tab_img.js");//1
jsurl.push("wp-content/themes/Likedome/js/jsfan/tip/tooltip.js");//2

jsurl.push("wp-content/themes/Likedome/js/jsfan/dropdownmenu/menus.js");//3
jsurl.push("wp-content/themes/Likedome/js/jsfan/dropdownmenu/bgpos.js");//4

jsurl.push("wp-content/themes/Likedome/js/jsfan/scrolling_img/scrolling_img.js");//5

jsurl.push("wp-content/themes/Likedome/js/jsfan/scrolling_text/scrolling_text.js");//6
jsurl.push("wp-content/themes/Likedome/js/jsfan/scrolling_text/list_text.js");//7

jsurl.push("wp-content/themes/Likedome/js/jsfan/slide/slide.js");//8
jsurl.push("wp-content/themes/Likedome/js/jsfan/slide/slide2.js");//9
jsurl.push("wp-content/themes/Likedome/js/jsfan/slide/slide4.js");//10
jsurl.push("wp-content/themes/Likedome/js/jsfan/slide/slide3.js");//11

jsurl.push("wp-content/themes/Likedome/js/jsfan/tab/show_obj.js");//12

jsurl.push("wp-content/themes/Likedome/js/jsfan/load/lazyload.js");//13

jsurl.push("wp-content/themes/Likedome/js/jsfan/backToTop/back_top.js");//14

var scl="<script src='";
var scr="'></script>";
var callobj=function(ay){
	jQuery.each(ay,function(i,n){
		document.write(scl+jsurl[n]+scr);		   
	});
};
