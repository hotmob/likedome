/* JS Document 
Version:	1.0
Date:		2010/10/16
Author:		XX
Update:
*/
/*
.btnArea
#showpic
.pic

*/

(function($) {
	$.slide_txt=function(wih,maos,btnArea,showpic,pic){
		var nowi=-1;
		var outsize=0;
		var out;
		movestar();
		$(btnArea+" a").each(function(i){
			$(this).hover(function(){
				var moveleft=i*wih;
				$(showpic).animate({left:'-'+moveleft+'px'},400);
				$(this).addClass("on");
				$(btnArea+" a").not($(this)).removeClass("on");
				nowi=i;
				clearTimeout(t);
			});
		});
		var nowp=-1;
		function movestar(){
			if(nowi<$(pic).length-1){
				nowi=nowi+1;
			}else{
			nowi=0;
			}
			var movel=nowi*wih;
			$(showpic).animate({left:'-'+movel+'px'},500);
			$(btnArea+" a:eq("+nowi+")").addClass("on");
			$(btnArea+" a").not($(btnArea+" a:eq("+nowi+")")).removeClass("on");
			t=setTimeout(movestar,maos);
		}
		function movestop(){
			clearTimeout(t);
		};
		$(btnArea).hover(function(){
		movestop();if(outsize=="1"){clearTimeout(out);}
		},function(){
		out=setTimeout(movestar,2000);
		outsize=1;
		});
	}
	$.fn.slide_txt=function(wih,maos,btnArea,showpic,pic){
		var wih = wih || 430;
		var maos = maos || 4000;
		var btnArea=btnArea || '.btnArea';
		var showpic=showpic || '#showpic';
		var pic=pic || '.pic';
		new $.slide_txt(wih,maos,btnArea,showpic,pic);
		return this;
	}
})(jQuery);











