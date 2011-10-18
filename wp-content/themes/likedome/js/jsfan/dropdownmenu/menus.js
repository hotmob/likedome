/* JS Document 
Version:	1.0
Date:		2010/10/16
Author:		XX
Update:
*/
(function($){
	$.fn.hoverIntent = function(f,g) {
		var cfg = {sensitivity: 7,interval:1,timeout: 0};
		cfg = $.extend(cfg, g ? { over: f, out: g } : f );
		var cX, cY, pX, pY;
		var track = function(ev) {cX = ev.pageX;cY = ev.pageY;};
		var compare = function(ev,ob) {
			ob.hoverIntent_t = clearTimeout(ob.hoverIntent_t);
			if ( ( Math.abs(pX-cX) + Math.abs(pY-cY) ) < cfg.sensitivity ) {
				$(ob).unbind("mousemove",track);
				ob.hoverIntent_s = 1;
				return cfg.over.apply(ob,[ev]);
			} else {
				pX = cX; pY = cY;
				ob.hoverIntent_t = setTimeout( function(){compare(ev, ob);} , cfg.interval );
			}
		};
		var delay = function(ev,ob) {
			ob.hoverIntent_t = clearTimeout(ob.hoverIntent_t);
			ob.hoverIntent_s = 0;
			return cfg.out.apply(ob,[ev]);
		};
		var handleHover = function(e) {
			var p = (e.type == "mouseover" ? e.fromElement : e.toElement) || e.relatedTarget;
			while ( p && p != this ) { try { p = p.parentNode; } catch(e) { p = this; } }
			if ( p == this ) { return false; }
			var ev = jQuery.extend({},e);
			var ob = this;
			if (ob.hoverIntent_t) { ob.hoverIntent_t = clearTimeout(ob.hoverIntent_t); }
			if (e.type == "mouseover") {
				pX = ev.pageX; pY = ev.pageY;
				$(ob).bind("mousemove",track);
				if (ob.hoverIntent_s != 1) { ob.hoverIntent_t = setTimeout( function(){compare(ev,ob);} , cfg.interval );}
			} else {
				$(ob).unbind("mousemove",track);
				if (ob.hoverIntent_s == 1) { ob.hoverIntent_t = setTimeout( function(){delay(ev,ob);} , cfg.timeout );}
			}
		};
		return this.mouseover(handleHover).mouseout(handleHover);
	};
})(jQuery);
(function($){
	$.fn.menusdl=function(){
		jQuery($).hoverIntent( 
			function(){ $(this).children("dd").show();$(this).children("dt").attr("class","cur");},
			function(){ $(this).children("dd").hide();$(this).children("dt").attr("class","");} 
		);
		return this;
	};
	$.fn.menus=function(yangs){	
		$(this).hoverIntent( 
			function(){$(this).children("ul").show();$(this).children("a").attr("class","select"+yangs);},
			function(){$(this).children("ul").hide();$(this).children("a").attr("class",""+yangs);} 
		);
		return this;
	};
})(jQuery);


