/* JS Document 
Version:	1.0
Date:		2010/10/16
Author:		XX
Update:
*/
(function($) {
  $.fn.fadPicture = function(d,type) {
    var df = 3000;
	var type=type||0
    delay = d ? (d < df ? df : d) : df;
    $(this).each(function(i){
      var t = $(this),
        mc = function(){
          var  ul = t,
            first = ul.find('li:first');
          if(type==1)
		  {
			ul.fadeOut('show',function(){first.appendTo(ul);});
		  	ul.fadeIn();
		  }
		  else
		  {
			ul.hide();
			first.appendTo(ul);
			ul.show();  
		  }
        };
      var interval = setInterval(function(){
        mc();
      }, delay);
      t.hover(
        function(){
          clearInterval(interval);
          t.data('start',false);
        },
        function(){
          interval = setInterval(function(){
            mc();
          }, delay);
        }
      );
    });
  };
})(jQuery);