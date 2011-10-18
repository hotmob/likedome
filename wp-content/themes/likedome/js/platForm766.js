//JQ call
callobj([0]);
$(function(){
	//tab
	$("#tab").tab();
	$("#tab1").tab();
	$("#tab2").tab();
	$("#tab3").tab();
	$("#tab4").tab();
	$("#tab5").tab();
	//server
	$(".server").hover(function(){
		$(this).stop().animate({width:'156px'},400);
	},function(){
		$(this).stop().animate({width:'48px'},400);
	});
	//suggest
	$(".suggest-open").click(function(){
		$(".suggest").toggle();
		return false;
	});
	$(".suggest-close").click(function(){
		$(".suggest").hide();
		return false;
	});
	//fixed IE6 bug
	$.fn.yy_position=function(ww,hh){
		var t = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop;
		var w = document.documentElement.clientWidth ? document.documentElement.clientWidth : document.body.clientWidth;
		var h = document.documentElement.clientHeight ? document.documentElement.clientHeight : document.body.clientHeight;
		var l1= ((w - ww) / 2) + 'px';
		var t1 = (t + (h - hh) / 2) + 'px';
		if(ww != null)
			$(this).css({top:t1,left:l1});
		if(ww == null)
			$(this).css({top:t1,right:0});
		return this;
	}
	var yy_b_v = navigator.appVersion;
	var yy_isIE6 = yy_b_v.search(/MSIE 6/i) != -1;	
	if (yy_isIE6 && window.attachEvent){
		window.attachEvent('onscroll', function(){jQuery(".suggest").yy_position(330,330)});	
		window.attachEvent('onresize', function(){jQuery(".suggest").yy_position(330,330)});
		$(".suggest").yy_position(330,330);
		window.attachEvent('onscroll', function(){jQuery(".server").yy_position(null,266)});	
		window.attachEvent('onresize', function(){jQuery(".server").yy_position(null,266)});
		$(".server").yy_position(null,266);
	}
});
