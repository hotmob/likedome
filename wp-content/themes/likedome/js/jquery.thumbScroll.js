;(function($){
	$.fn.thumbScroll = function(setting){
		var defaults = {
			aTime: 500,		//动画时间，秒
			sTime: 3000		//轮播时间，秒
		};
		var setting = $.extend({},defaults,setting);
		return this.each(function(){
			//变量初始化
			var $sThumb = $(".sThumb"),
				$sUl = $sThumb.find("ul"),	//缩略图ul
				$sLi = $sThumb.find("li"),	//缩略图li
				$sShow = $(".sShow"),	//显示图片用的
				$sIul = $(".sImg"),	//图片列表
				$sIli = $sIul.find("li"),	//图片列表li
				sAry = new Array(),
				gate = 'open', //悬停动画开关
				curr = 4,	//默认显示
				time = 0;
			$sUl.find('li').clone().appendTo($sUl);
			$sIul.find('li').clone().appendTo($sIul);
			var	sLength = $sUl.find('li').length, //滚动条的内容个数
				sWidth = $sLi.outerWidth(), //滚动li的宽度
				$sWidth = "-" + sWidth;
			//状态初始化
			$(".sText ul").css({marginLeft:-2*sWidth+'px'});
			for(var i = sLength-1; i >= 0; i--){
				$sUl.find('li').eq(i).attr("num",i+1);
				sAry[i] = $sIul.find("li").eq(i).html();
			}
			//alert(sAry[13])
			for(var m=0; m<5; m++){
				$sUl.find('li:last').prependTo($sUl);
			}
			
			//动画
			var ani = {
				sLeft: function(step){ //左滚动
					var s = step || 1;
					//alert(s)
					$sUl.find('li').removeClass("sCurr");
					$sShow.fadeOut(setting.aTime);
					$sUl.animate({left: s*$sWidth + 'px'},setting.aTime,function(){
						for(var k=0; k<s; k++){
							$(this).find('li').eq(0).appendTo(this); //动画结束，首个元素添加到末尾
						}
						$(this).css({left:0});
						var $c = $sUl.find('li').eq(curr),
							$cEq = $c.attr("num")-1;
						$c.addClass("sCurr");
						$sShow.fadeIn(setting.aTime).html(sAry[$cEq]);
					});
					//alert(s*$sWidth)
				},
				sRight: function(step){ //右滚动
					var s = step || 1;
					$sUl.find('li').removeClass("sCurr");
					$sShow.fadeOut(setting.aTime);
					$sUl.animate({left : s*sWidth +'px'},setting.aTime,function(){
						for(var k=0; k<s; k++){
							$(this).find('li').eq(sLength-1).prependTo(this); //动画结束，最后的元素加到开头
						}
						var $c = $sUl.find('li').eq(curr),
							$cEq = $c.attr("num")-1;
						$(this).css({left:0});
						$c.addClass("sCurr");
						$sShow.fadeIn(setting.aTime).html(sAry[$cEq]);
					});
				},
				autoPlay: function(){ //轮播
					if(gate == 'open')	ani.sLeft();
					else gate = 'open';
					time = setTimeout(ani.autoPlay,setting.sTime);					
				}			
			}
			//开启自动轮播
			ani.autoPlay();
			//鼠标悬停
			$('.thumbScroll').hover(function(){
				clearTimeout(time);
			},function(){
				gate = 'close';
				ani.autoPlay();
			});
			//点击播放
			$(".thumbScroll .sLeft").click(function(){
				ani.sRight();
			});
			$(".thumbScroll .sRight").click(function(){
				ani.sLeft();
			});
			//显示被点击轮播
			$sUl.find('li').each(function(i,j){
				$(j).click(function(){
					var eq = $(j).attr("num"),
						$cEq = $sUl.find('li').eq(curr).attr("num");
					if(eq == $cEq) return;
					if($(j).position().left>$sUl.find('li').eq(curr).position().left){
						var go1 = parseInt(($(j).position().left - $sUl.find('li').eq(curr).position().left)/sWidth);
						ani.sLeft(go1);
					}
					if($(j).position().left<$sUl.find('li').eq(curr).position().left){
						var  go2 = parseInt(($sUl.find('li').eq(curr).position().left - $(j).position().left)/sWidth);
						ani.sRight(go2);
					}
				});
			});
		});		
	}
})(jQuery);