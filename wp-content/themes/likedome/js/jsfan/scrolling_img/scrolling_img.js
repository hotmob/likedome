/* JS Document 
Version:	1.0
Date:		2010/06/08
Author:		Kaijun Ni
Update:
*/
(function($){
     $.fn.scrollerimg = function(options){
         var opts = $.extend({},$.fn.scrollerimg.defaults, options);
         return this.each(function(){
             var $marquee = $(this);
             var _scrollObj = $marquee.get(0);
             var scrollW = $marquee.width();
             var scrollH = $marquee.height();
             var $element = $marquee.children();
             var $kids = $element.children();
             var scrollSize=0;
             var _type = (opts.direction == 'left' || opts.direction == 'right') ? 1:0;
             $element.css(_type?'width':'height',10000);
             if (opts.isEqual) {
                 scrollSize = $kids[_type?'outerWidth':'outerHeight']() * $kids.length;
             }else{
                 $kids.each(function(){
                     scrollSize += $(this)[_type?'outerWidth':'outerHeight']();
                 });
             }
             $element.append($kids.clone()).css(_type?'width':'height',scrollSize*2);
             var numMoved = 0;
             function scrollFunc(){
                 var _dir = (opts.direction == 'left' || opts.direction == 'right') ? 'scrollLeft':'scrollTop';
                 if (opts.loop > 0) {
                     numMoved+=opts.scrollAmount;
                     if(numMoved>scrollSize*opts.loop){
                         _scrollObj[_dir] = 0;
                         return clearInterval(moveId);
                     } 
                 }
                 if(opts.direction == 'left' || opts.direction == 'up'){
                     _scrollObj[_dir] +=opts.scrollAmount;
                     if(_scrollObj[_dir]>=scrollSize){
                         _scrollObj[_dir] = 0;
                     }
                 }else{
                     _scrollObj[_dir] -=opts.scrollAmount;
                     if(_scrollObj[_dir]<=0){
                         _scrollObj[_dir] = scrollSize;
                     }
                 }
             }
             var moveId = setInterval(scrollFunc, opts.scrollDelay);
             $marquee.hover(
                 function(){
                     clearInterval(moveId);
                 },
                 function(){
                     clearInterval(moveId);
                     moveId = setInterval(scrollFunc, opts.scrollDelay);
                 }
             );
			 if(opts.direction == 'left'|| opts.direction == 'right')
			 {
				$marquee.parent().find('.imgright').mouseover(function(){
					clearInterval(moveId);
					opts = $.extend({},$.fn.scrollerimg.defaults, {direction:'left',scrollAmount:2});
					moveId = setInterval(scrollFunc,1);
				});
				$marquee.parent().find('.imgright').mouseout(function(){
					clearInterval(moveId);
					opts = $.extend({},$.fn.scrollerimg.defaults, {direction:'left',scrollAmount:1});
					moveId = setInterval(scrollFunc, opts.scrollDelay);
				});
				$marquee.parent().find('.imgleft').mouseover(function(){
					clearInterval(moveId);
					opts = $.extend({},$.fn.scrollerimg.defaults, {direction:'right',scrollAmount:2});
					moveId = setInterval(scrollFunc,1);
				});
				$marquee.parent().find('.imgleft').mouseout(function(){
					clearInterval(moveId);
					opts = $.extend({},$.fn.scrollerimg.defaults, {direction:'right',scrollAmount:1});
					moveId = setInterval(scrollFunc, opts.scrollDelay);
				});
			 }
			 else
			 {
				 $marquee.parent().find('.imgdown').mouseover(function(){
					clearInterval(moveId);
					opts = $.extend({},$.fn.scrollerimg.defaults, {direction:'up',scrollAmount:2});
					moveId = setInterval(scrollFunc,1);
				});
				$marquee.parent().find('.imgdown').mouseout(function(){
					clearInterval(moveId);
					opts = $.extend({},$.fn.scrollerimg.defaults, {direction:'up',scrollAmount:1});
					moveId = setInterval(scrollFunc, opts.scrollDelay);
				});
				$marquee.parent().find('.imgup').mouseover(function(){
					clearInterval(moveId);
					opts = $.extend({},$.fn.scrollerimg.defaults, {direction:'down',scrollAmount:2});
					moveId = setInterval(scrollFunc,1);
				});
				$marquee.parent().find('.imgup').mouseout(function(){
					clearInterval(moveId);
					opts = $.extend({},$.fn.scrollerimg.defaults, {direction:'down',scrollAmount:1});
					moveId = setInterval(scrollFunc, opts.scrollDelay);
				});
			 }
         });
     };
     $.fn.scrollerimg.defaults = {
         isEqual:true,//所有滚动的元素长宽是否相等,true,false
         loop: 0,//循环滚动次数，0时无限
         direction: 'left',//滚动方向，'left','right','up','down'
         scrollAmount:1,//步长
         scrollDelay:60,//时长
		 num:4
     };
     $.fn.scrollerimg.setDefaults = function(settings) {
         $.extend( $.fn.scrollerimg.defaults, settings );
     };
})(jQuery);

