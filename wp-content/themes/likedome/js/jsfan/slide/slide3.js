/* JS Document 
Version:	1.0
Date:		2010/10/16
Author:		XX
Update:
*/
/*
.full
.pictext
*/
(function($){
	$.slide_img=function(obj,full,pictext){
		var flg=0;
		var flgr=0;
		var t;
		function move(){
			obj.find(full+" img").eq(flg).fadeIn("slow");
			obj.find(full+" img").not(obj.find(full+" img").eq(flg)).fadeOut("slow");
			obj.find(pictext).eq(flg).fadeIn("slow");
			obj.find(pictext).not(obj.find(pictext).eq(flg)).fadeOut("slow");
			obj.find(".picbg").fadeTo(300, 0.5);
			obj.find(".small li").eq(flg).addClass("picbj");
			obj.find(".small li").not(obj.find(".small li").eq(flg)).removeClass("picbj");
			obj.find(".small li:eq("+flg+") img").css({"border":"#f00 solid 1px"});
			obj.find(".small li img").not(obj.find(".small li:eq("+flg+") img")).css({"border":"#c4c5c6 solid 1px"});
			flg=flg+1;
			t=setTimeout(move,3000);
			if(flg==5){flg=0;}
		}
		move();
		obj.hover(function(){
				flgr=0;
				clearTimeout(t);
		},function(){
				if(flgr==0){
				t=setTimeout(move,3000);
				}else{
				flg=flg+1;
				t=setTimeout(move,3000);
				}
				});
		obj.find("ul.small li").each(function(i){
			$(this).click(function(){
				clearTimeout(t);
				flgr=1;
				flg=i;
				$(full+" img").eq(flg).fadeIn("slow");
				$(full+" img").not($(full+" img").eq(flg)).fadeOut("slow");
				$(pictext).eq(flg).fadeIn("slow");
				$(pictext).not($(pictext).eq(flg)).fadeOut("slow");
				
				$(".picbg").fadeTo(300, 0.5);
				
				$(".small li").eq(flg).addClass("picbj");
		
				$(".small li").not($(".small li").eq(flg)).removeClass("picbj");
				
				$(".small li:eq("+flg+") img").css({"border":"#f00 solid 1px"});
				$(".small li img").not($(".small li:eq("+flg+") img")).css({"border":"#c4c5c6 solid 1px"});
				t=setTimeout(move,3000);
			});
		});
	};
	$.fn.slide_img=function(){
		new $.slide_img($(this),".full",".pictext");
		return this;
	};
})(jQuery);