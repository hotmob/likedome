/* JS Document 
Version:	1.0
Date:		2010/10/16
Author:		XX
Update:
*/
(function($){
	$.slide=function(ifocus_piclist,ifocus_btn,ifocus_tx){
		var currentIndex = 0;
		var DEMO;
		var currentID = 0;
		var pictureID = 0;
		$(ifocus_piclist+" li").eq(0).show();
		autoScroll();
		$(ifocus_btn+" li").hover(function() {
			StopScrolll();
			$(ifocus_btn+" li").removeClass("current")
			$(this).addClass("current");
			currentID = $(this).attr("id");
			pictureID = currentID.substring(currentID.length - 1);
			$(ifocus_piclist+" li").eq(pictureID).fadeIn("slow");
			$(ifocus_piclist+" li").not($(ifocus_piclist+" li")[pictureID]).hide();
			$(ifocus_tx+" li").hide();
			$(ifocus_tx+" li").eq(pictureID).show();
		}, function() {
			currentID = $(this).attr("id");
			pictureID = currentID.substring(currentID.length - 1);
			currentIndex = pictureID;
			autoScroll();
		});
		function autoScroll() {
			$(ifocus_btn+" li:last").removeClass("current");
			$(ifocus_tx+" li:last").hide();
			$(ifocus_btn+" li").eq(currentIndex).addClass("current");
			$(ifocus_btn+" li").eq(currentIndex - 1).removeClass("current");
			$(ifocus_tx+" li").eq(currentIndex).show();
			$(ifocus_tx+" li").eq(currentIndex - 1).hide();
			$(ifocus_piclist+" li").eq(currentIndex).fadeIn("slow");
			$(ifocus_piclist+" li").eq(currentIndex - 1).hide();
			currentIndex++; currentIndex = currentIndex >= $(ifocus_piclist+" li").length ? 0 : currentIndex;
			DEMO = setTimeout(autoScroll, 3000);
		}
		function StopScrolll(){
			clearTimeout(DEMO);
		}
	};
	$.fn.slide=function(ifocus_piclist,ifocus_btn,ifocus_tx){
		new $.slide(ifocus_piclist,ifocus_btn,ifocus_tx);
		return this;
	};
})(jQuery);

