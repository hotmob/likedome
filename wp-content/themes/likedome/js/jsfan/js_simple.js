/* JS Document 
Version:	1.0
Date:		2010/10/16
Author:		XX
Update:
*/
var simple={
	$$:function(id){return document.getElementById(id);},
	//页面加载后才执行
	oload:function(fcn){
		if(document.all){
			window.attachEvent("onload",fcn);
		}else{
			window.addEventListener("load",fcn, true);
		}
	},
	hover:function(obj,fn1,fn2){
		obj.onmouseover=fn1;
		obj.onmouseout=fn2;
	},
	//设为首页
	setHomePage:function(obj){ 
		var aUrls=document.URL.split("/"); 
		var vDomainName="http://"+aUrls[2]+"/"; 
		try{//IE 
			obj.style.behavior="url(#default#homepage)"; 
			obj.setHomePage(vDomainName); 
		}catch(e){//other 
		if(window.netscape) {//ff 
			try { 
				netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect"); 
			} 
			catch (e) { 
				alert("此操作被浏览器拒绝！/n请在浏览器地址栏输入“about:config”并回车/n然后将[signed.applets.codebase_principal_support]设置为'true'"); 
			} 
				var prefs = Components.classes['@mozilla.org/preferences-service;1'].getService(Components.interfaces.nsIPrefBranch); 
				prefs.setCharPref('browser.startup.homepage',vDomainName); 
			} 
		} 
	},
	//添加到收藏夹
	addFavorite:function(){ 
		var aUrls=document.URL.split("/"); 
		var vDomainName="http://"+aUrls[2]+"/"; 
		var description=document.title; 
		try{//IE 
			window.external.AddFavorite(vDomainName,description); 
		}catch(e){//FF 
			window.sidebar.addPanel(description,vDomainName,""); 
		} 
	},
	//分享给好友
	copyCode:function(){
		copyToClipBoard=function(title){
			var clipBoardContent="";
			clipBoardContent+=title;
			clipBoardContent+="\n";
			clipBoardContent+=this.location.href;
		   if(window.clipboardData){ 
				  window.clipboardData.clearData(); 
				  window.clipboardData.setData("Text", clipBoardContent);
		   }else if(navigator.userAgent.indexOf("Opera") != -1){ 
				  window.location = clipBoardContent; 
		   }else if (window.netscape){ 
				  try{ 
						 netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect"); 
				  }catch (e){ 
						 alert("您的当前浏览器设置已关闭此功能！请按以下步骤开启此功能！\n新开一个浏览器，在浏览器地址栏输入'about:config'并回车。\n然后找到'signed.applets.codebase_principal_support'项，双击后设置为'true'。\n声明：本功能不会危极您计算机或数据的安全！"); 
				  } 
				  var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard); 
				  if (!clip) return; 
				  var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable); 
				  if (!trans) return; 
				  trans.addDataFlavor('text/unicode'); 
				  var str = new Object(); 
				  var len = new Object(); 
				  var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString); 
				  var copytext = clipBoardContent; 
				  str.data = copytext; 
				  trans.setTransferData("text/unicode",str,copytext.length*2); 
				  var clipid = Components.interfaces.nsIClipboard; 
				  if (!clip) return false; 
				  clip.setData(trans,null,clipid.kGlobalClipboard); 
		   }
		   return true;
		}
		var testTitle=document.title;
		if(copyToClipBoard(testTitle)!=false){ 
			alert("已经复制到粘贴板，你可以使用Ctrl+V 贴到需要的地方去了哦!"); 
		} 
	},
	textlfet:function(div1,div2,div3,sll,time){
		s=this.$$(div1);
		s2=this.$$(div2);
		s3=this.$$(div3);
		s4=this.$$(sll);
		this.hover(s,function(){
			clearInterval(timer)
		},function(){
			timer=setInterval(mar,time)
		});
		s4.style.width=(s2.offsetWidth*2+100)+"px";
		s3.innerHTML=s2.innerHTML;
		timer=setInterval(mar,time)
		function mar(){
			if(s2.offsetWidth<=s.scrollLeft){
				s.scrollLeft-=s2.offsetWidth;
			}else{s.scrollLeft++;}
		}
	},
	textup:function(ul, delay, speed, lineHeight){
		var slideBox = (typeof ul == 'string')?document.getElementById(ul):ul;
		var delay = delay||1000;
		var speed=speed||20;
		var lineHeight = lineHeight||20;
		var tid = null, pause = false;
		var start = function() {
		tid=setInterval(slide, speed);
		}
		var slide = function() {
		if (pause) return;
		slideBox.scrollTop += 2;
		if ( slideBox.scrollTop % lineHeight == 0 ) {
		clearInterval(tid);
		slideBox.appendChild(slideBox.getElementsByTagName('li')[0]);
		slideBox.scrollTop = 0;
		setTimeout(start, delay);
		}
		}
		slideBox.onmouseover=function(){pause=true;}
		slideBox.onmouseout=function(){pause=false;}
		setTimeout(start, delay);
	},
	tab:function(tab_menu,tab_main,cur_tab,mouse,time){
		var pre_no;
		var timer,autoplay_timer;
		var tab;
		function $1( id ){ return document.getElementById( id );}
		function run( no ){
			if( no != null ){
				if( timer != null )clearInterval( timer );
				timer = setInterval( function(){
					doChange(no);
				},200 );
			}
		}
		function addEvent(){
			for( var i = 0; i < tab.length; i++ ){
				tab[i].cur_no = i;
				if( mouse == null ){
					tab[i].onclick = function(){ 
						run( this.cur_no );
						return false;
					}
				} else {
					tab[i].onmouseover = tab[i].onmouseout= function(){
						run( this.cur_no );
						return false;
					}
				}
			}
		}
		function doChange( k ){
			if( tab[pre_no] != null && $1(tab_main+(pre_no+1)) != null ){
				tab[pre_no].className = "off";
				$1(tab_main+(pre_no+1)).style.display = "none";
			}
			
			if( tab[k] != null && $1(tab_main+(k+1)) != null ){
				tab[k].className = "on";
				$1(tab_main+(k+1)).style.display = "block";
			}
			
			pre_no = k;
			if( timer != null )clearInterval( timer );
		}
		function autoplay(){
			if( pre_no < tab.length ){
				doChange( pre_no+1 );
			} else {
				pre_no = tab.length-1;
				doChange( 0 );
			}
		}
		function init(){
			if( tab_menu == null || tab_main == null ) return;
			
			var tabs = tab_menu.split(" ");
			
			if( tabs[0] == null || tabs[1] == null || $1( tabs[0] ) == null ) return;
			
			tab = $1( tabs[0] ).getElementsByTagName( tabs[1] );
	
			pre_no = ( cur_tab == null ) ? 0:(cur_tab-1);
			
			doChange( pre_no );
			addEvent();
			
			if( time != null && time > 0 )
				autoplay_timer = setInterval( autoplay,time );
		}
		init();
	},
	fdTm:{},
	cnt : 0,
	fadeIn: function(){
		this.$$('focus').style.cssText = "filter: alpha(opacity="+ this.cnt*10 +"); opacity:"+this.cnt*10+";"; 
		if(this.cnt<10){
			this.fdTm = window.setTimeout("simple.fadeIn()", 80);
			this.cnt++;
		}
		else{
			this.cnt = 0;
			window.clearTimeout(this.fdTm);
		}
	},
	trim: function(s){
		return s.replace(/(^\s*)|(\s*$)/g, "");
	},
	Focus: function(s,t){//s图片，t滚动的小图片
		if(!this.$$(s))return;//图片对象判断是否穿在
		if(!this.$$(t))return;//小图片对象判断是否存在
		var thumb_div = this.$$(t).getElementsByTagName('div')[0];//获得列表对象
		var image_div = this.$$(s);//获得小图片列表
		var thumb_ul = thumb_div.getElementsByTagName('ul')[0];//获得ul
		var thumb_li= thumb_div.getElementsByTagName('li');
			if(thumb_li.length>4)thumb_ul.innerHTML+=thumb_ul.innerHTML;//复制li（2倍）
		var thumb_lis = thumb_div.getElementsByTagName('li');//获得所有li对象
		var thumb_lic = thumb_lis.length;//获得li对象的个数
		if(thumb_lic==0)return;//如果thumb_lic为0返回
		var li_width = thumb_lis[0].offsetWidth;//一个li的宽度
			thumb_ul.style.width = (li_width * thumb_lic) + 'px';//所有li的宽度
		var w = (thumb_lic / 2) * li_width;	  //获得一半的宽度
		var timer = timer1 = null;//初始化
		var d = 'left';
		var a = this.$$(t).getElementsByTagName('a');//获得小图片里面的所有a
		var Index = 0;//焦点0
		thumb_div.scrollLeft = 0;
		setImg(0);

		a[0].onclick = function(){clearInterval(timer);d='left';doSlide(d, 4);timer = setInterval(function(){setImg(Index);return false;}, 3000);return false;};
		a[1].onclick = function(){clearInterval(timer);d='right';doSlide(d, 4);timer = setInterval(function(){setImg(Index);return false;}, 3000);return false;};
		a[0].onfocus = a[1].onfocus = function(){this.blur();};
		for(var i=0;i<thumb_lis.length;i++){
			thumb_lis[i].setAttribute('Index', i.toString());
			//thumb_lis[i].className = '';
			/*
			thumb_lis[i].onmouseover = function(){if(this.className.toString().indexOf('selected')==-1)this.className='current';};	
			thumb_lis[i].onmouseout = function(){if(this.className.toString().indexOf('selected')==-1)this.className='';};
			*/
			thumb_lis[i].onclick = function(){
				clearInterval(timer);
				var iIndex = Math.floor(this.getAttribute('Index').toString());
				//d = iIndex > Index ? 'left' : 'right';
				//doSlide(d,1);
				//this.blur();
				this.getElementsByTagName('a')[0].onclick = function(){return false;};
				Index=iIndex;
				setImg1(iIndex);
				//Index=iIndex+1;
				timer = setInterval(function(){setImg(Index);return false;}, 3000);
				return false;
			};
		}
		//thumb_lis[0].className="current selected";
		focus_start(d);
		function focus_start(direction){//alert(Index);
			if(Index % 4==0 && Index!=0){
				if(thumb_li.length>4)doSlide(d, 4);
				return;
			}
			timer = setInterval(function(){setImg(Index);}, 3000);
		}
		function doSlide(d, n){
			Index = (thumb_div.scrollLeft / li_width);
			for(var i=0;i<thumb_lis.length;i++){
				thumb_lis[i].className = '';
			}
			if(d=='left'){
				/*左邊*/
				if(thumb_div.scrollLeft >= w){
					thumb_div.scrollLeft = 0;
				}
				thumb_lis[Index].className = '';
				for(var i=0;i<(li_width * n);i++){
					if(i >= (li_width * n))break;
					thumb_div.scrollLeft += 1;
				}
				Index = (thumb_div.scrollLeft / li_width);
			}else if(d=='right'){
				/*右邊*/
				if(thumb_div.scrollLeft == 0){
					thumb_div.scrollLeft = w;
				}
				thumb_lis[Index].className = '';
				for(var i=0;i<(li_width * n);i++){
					if(i >= (li_width * n))break;
					thumb_div.scrollLeft -= 1;
				}
				Index = (thumb_div.scrollLeft / li_width);
			}
				setImg1(Index);
		}
		
		function setImg(idx){
			if(thumb_li.length<8)
			{
				if(idx>3)
				{idx=0;Index=0;}
				
			}
			else
			{
				if(idx==8)
				{idx=0;}
				
			}
			//document.title = idx;			
			if(Index % 4==0 && Index!=0){
				d="right";
				if(thumb_li.length>4)
				{doSlide(d, 4);
				 Index-=1;}
				//return;
			}
			for(var i=0;i<thumb_lis.length;i++){
				thumb_lis[i].className = '';//设置所有li的样式为空
			}
			thumb_lis[idx].className = 'current selected';//设置下li[idx]样式
			var ii = thumb_lis[idx].getElementsByTagName('img')[0];//获得li[idx]的图片对象
			if(!ii)return;//如果没有图片对象
			var img = '';//初始化图片地址
			if(ii.getAttribute('image')){//判断图片地址是否存在，不穿在就用小图片的地址
				img = ii.getAttribute('image').toString();//获得图片地址，并强制转换字符串（大）
			}else{
				img = ii.getAttribute('src').toString();//获得图片地址，并强制转换字符串（小）
			}
			var url = thumb_lis[idx].getElementsByTagName('a')[0].href;//获得链接地址
			image_div.innerHTML = "<a href=\""+url+"\"target=\"_blank\"><img src=\""+img+"\" /></a>";//填充大图片
			Index+=1;//设置焦点+1
			this.cnt = 0;
			window.clearTimeout(this.fdTm);
			simple.fadeIn();	
		}
		function setImg1(idx){
			for(var i=0;i<thumb_lis.length;i++){
				thumb_lis[i].className = '';
			}

			thumb_lis[idx].className = 'current selected';
			var ii = thumb_lis[idx].getElementsByTagName('img')[0];
			if(!ii)return;
			var img = '';
			if(ii.getAttribute('image')){
				img = ii.getAttribute('image').toString();
			}else{
				img = ii.getAttribute('src').toString();
			}
			var url = thumb_lis[idx].getElementsByTagName('a')[0].href;
			image_div.innerHTML = "<a href=\""+url+"\"target=\"_blank\"><img src=\""+img+"\" /></a>";
			Index+=1;
			this.cnt = 0;
			window.clearTimeout(this.fdTm);
			simple.fadeIn();	
		}
	},
	Focus_txt:function(hot_img,img_data,img_box){
		var hot_img=hot_img || "hot_img";
		var img_data=img_data || "img_data";
		var img_box=img_box || "img_box";
		var _dt=document.getElementById(img_data).getElementsByTagName("dt");
		var _dd=document.getElementById(img_data).getElementsByTagName("dd");
		var _box=document.getElementById(img_box);
		var _timer;
		if(_dt){
		_box.innerHTML=_dt[0].innerHTML;
		for(var i=0;i<_dd.length;i++){
		_dd[i].getElementsByTagName("span")[0].innerHTML=i+1;
		}
		scrollIMG();
		}
		if(_dd){
		for(var i=0;i<_dd.length;i++){
		_dd[i].getElementsByTagName("a")[0].onmouseover=function(){
		if(this.parentNode.className.toLowerCase()=="here"){return;}
		for(var i=0;i<_dd.length;i++){_dd[i].className="";}
		this.parentNode.className="here";
		_box.innerHTML=this.parentNode.parentNode.getElementsByTagName("dt")[0].innerHTML;
		}
		}
		document.getElementById(hot_img).onmouseover=function(){clearTimeout(_timer);}
		document.getElementById(hot_img).onmouseout=function(){clearTimeout(_timer);_timer=setTimeout(scrollIMG,2000);}
		}
		function scrollIMG(){
		var _index;
		for(var i=0;i<_dd.length;i++){if(_dd[i].className!=""){_index=i;break;}}
		_dd[_index].className="";
		if(_index==(_dd.length-1)){_index=0;}else{_index+=1;}
		_dd[_index].className="here";
		_box.innerHTML=_dd[_index].parentNode.getElementsByTagName("dt")[0].innerHTML;
		clearTimeout(_timer);
		_timer=setTimeout(scrollIMG,5000);
		}		
	}
}