var loadingProcess={isReady:false,url:"",init:function(){
	document.getElementById("loading").style.display="block";document.getElementById("flashCff").innerHTML='<object id=picMe name=picMe codeBase=http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0 height="1" width="1" classid=clsid:D27CDB6E-AE6D-11cf-96B8-444553540000><PARAM NAME="_cx" VALUE="5080"><PARAM NAME="_cy" VALUE="5080"><PARAM NAME="FlashVars" VALUE=""><PARAM NAME="Movie" VALUE="http://static.766.com/newspics/flash/loadingAs3.swf"><PARAM NAME="Src" VALUE="http://static.766.com/newspics/flash/loadingAs3.swf"><PARAM NAME="WMode" VALUE="Transparent"><PARAM NAME="Play" VALUE="-1"><PARAM NAME="Loop" VALUE="-1"><PARAM NAME="Quality" VALUE="High"><PARAM NAME="SAlign" VALUE=""><PARAM NAME="Menu" VALUE="-1"><PARAM NAME="Base" VALUE=""><PARAM NAME="AllowScriptAccess" VALUE="always"><PARAM NAME="Scale" VALUE="NoBorder"><PARAM NAME="DeviceFont" VALUE="0"><PARAM NAME="EmbedMovie" VALUE="0"><PARAM NAME="BGColor" VALUE=""><PARAM NAME="SWRemote" VALUE=""><PARAM NAME="MovieData" VALUE=""><PARAM NAME="SeamlessTabbing" VALUE="1"><PARAM NAME="Profile" VALUE="0"><PARAM NAME="ProfileAddress" VALUE=""><PARAM NAME="ProfilePort" VALUE="0"><PARAM NAME="AllowNetworking" VALUE="all"><PARAM NAME="AllowFullScreen" VALUE="true"><embed type="application/x-shockwave-flash" src="http://static.766.com/newspics/flash/loadingAs3.swf" id="picMeFF" name="picMeFF" wmode="window" quality="high" allownetworking="all" allowscriptaccess="always" allowfullscreen="true" scale="noborder" pluginspage="http://www.macromedia.com/go/getflashplayer" width="1" height="1"></embed></object>'
	},progressPicHandler:function(a,b,c){
		a=Math.floor(b*100/c)+"%";document.getElementById("loading").style.display="block";document.getElementById("loading").innerHTML="加载进度:"+a;picShow.pross=Math.floor(b*100/c)
	},completePicHandler:function(a){
		document.getElementById("loading").style.display="none";picShow.showPic(a);picShow.setTit()
	},ioErrorPicHandler:function(){
			document.getElementById("loading").style.display="block";document.getElementById("loading").innerHTML="加载失败";picShow.showPic("http://mat1.gtimg.com/ent/groupCSS/ajax-loadernone.gif")
	},errorplayer:function(){
	},thisMovie:function(a){
		return navigator.appName.indexOf("Microsoft")!=-1?window[a]:document[a]
	},load:function(a){
			picShow.setTit();(picShow.isIE?loadingProcess.thisMovie("picMe"):loadingProcess.thisMovie("picMeFF")).picLoader(a)},loadPic:function(){var a=new Image;a.src=this.url;if(a.complete){document.getElementById("loading").style.display="none";picShow.showPic(a.src);return false}loadingProcess.load(loadingProcess.url)
	},loadConnect:function(){var a=new Image;a.src=this.url;if(a.complete){document.getElementById("loading").style.display="none";picShow.showPic(a.src);return false}loadingProcess.load(loadingProcess.url)
	},isFlashReady:function(){loadingProcess.isReady=true;return loadingProcess.isReady}};
			
function Cookieset(a,b,c,d,f){
	if(typeof c=="undefined"){c=new Date((new Date).getTime()+864E5)}document.cookie=a+"="+escape(b)+(c?"; expires="+c.toGMTString():"")+(d?";path="+d:";path=/")+(f?";domain="+f:"")
}
function Cookieget(a){
	a=document.cookie.match(new RegExp("(^| )"+a+"=([^;]*)(;|$)"));
	if(a!=null){
		return unescape(a[2])
	}
	return null
}
function addEventHandler(a,b,c){
	if(a.addEventListener){a.addEventListener(b,c,false)}else{if(a.attachEvent){a.attachEvent("on"+b,c)}else{a["on"+b]=c}}
}
function removeEventHandler(a,b,c){
	if(a.removeEventListener){
		a.removeEventListener(b,c,false)
	}else{
		if(a.detachEvent){
			a.detachEvent("on"+b,c)
		}else{
			a["on"+b]=null
		}
	}
}

var oldObj=null,youCanScroll=false,disObj=null,picShow={};
picShow={$:function(a){return document.getElementById(a)},
		isIE:navigator.appVersion.indexOf("MSIE")!=-1?true:false,
		isFrist:false,
		Src:[],
		Img_prv:new Image,
		Img_Next:new Image,
		Img:new Image,
		Mark:"p",
		defatLink:"http://www.766.com/",
		SiteName:"www",
		ops:0,
		opsE:70,
		Count:photoJson.length,
		Now:0,
		imgW:570,
		imgH:450,pross:0,lastUrl:"",timerMe:null,
		titleStr:document.title,posX:null,posY:null,Cleft:0,Mleft:0,
		niersenPath:"/niersen_tongji.htm",tmpLeft:0,tmpRight:0,
		tmpType:'down',
		Display:function(a,b){
			this.Now=Number(b);
			this.showSmallImageStatic("smallPhoto");
			loadingProcess.isReady==false&&loadingProcess.init();
			this.Img.src=this.Src[Number(this.Now)];
			picShow.SrcFUn(this.Img.src);
			if(b==0){
				this.Img_Next.src=this.Src[this.Now+1]
			}else{
				if(b!=Number(this.Count-1)){
					this.Img_Next.src=this.Src[this.Now+1]
				}
				this.Img_prv.src=this.Src[this.Now-1]
			}
		},SrcFUn:function(a){
			loadingProcess.url=a;
			if(picShow.isFrist){
				loadingProcess.loadPic()
			}else{
				picShow.isFrist=true
			}
		},changImg:function(a,b){
			var c=new Image;c.src=a.src;
			
			
			var d=c.width;
			if(parseInt(d)>0){
				a.width=c.width>=b?b:d
			};
			
			picShow.$("preArrow").style.height=picShow.$("nextArrow").style.height=c.height
		},showPic:function(a){
				
			picShow.$("Display").src=a;picShow.opchangShow(picShow.$("Display"),100,20,5);
			picShow.$("Display").style.visibility="visible";document.getElementById("loading").style.display="none";
			picShow.$("picTips").style.display="block";picShow.showTips(Number(picShow.Now));picShow.setTit();
			picShow.$("artwork").href=a;
			picShow.$("Display").onload=function(){
										picShow.changImg(picShow.$("Display"),picShow.imgW);
										var b=window.location.href.split("#")[0]+"#"+picShow.Mark+"="+(parseInt(Number(picShow.Now),10)+1);
										window.location.href=b;};
			picShow.changImg(picShow.$("Display"),picShow.imgW);
			addCount(picShow.Now)
		},setTit:function(){
				document.title=this.titleStr
		},lastGoto:function(a){
				if(a=="open"){
					this.$("gotolast_inner").style.top=this.$("gotolast").style.top=parseInt(parseInt(picShow.$("Display").height,10)-78)/2+"px";this.$("gotolast_inner").style.left=this.$("gotolast").style.left="170px";
					this.$("gotolast").style.display="block";this.$("gotolast_inner").style.display="block";
					if(this.lastUrl!==""){
						this.$("urlgoto").innerHTML="进入下一组图";
						this.$("urlgoto").onclick = function(){
							window.open(picShow.lastUrl);
						}
						//this.$("urlgoto").href=picShow.lastUrl
					}else{
						this.$("urlgoto").innerHTML="进入图片站";
						this.$("urlgoto").onclick = function(){
							window.open(picShow.defatLink);
						}
						//this.$("urlgoto").href=picShow.defatLink
					}
					this.$("rePlay").href="#";
					addEventHandler(picShow.$("rePlay"),"click",function(e){var event=window.event||e;var srcEl=event.srcElement?event.srcElement:event.target;if(srcEl.id=="rePlay"){picShow.Now=0;picShow.Display("next",0);picShow.lastGoto("close")}return false});
					addEventHandler(picShow.$("rePlay"),"focus",function(){picShow.$("rePlay").blur()});
					if(picShow.isIE){
						window.event.cancelBubble=true;
						return false
					}else{
							//event.stopPropagation();
							return false
					}
				}else{
					this.$("gotolast").style.display="none";
					this.$("gotolast_inner").style.display="none";
				}
		},showTips:function(a){
				if(Cookieget("oPENtIPS")=="show"||Cookieget("oPENtIPS")==null){
					this.$("picTips").style.display="block";
					this.$("openTips").style.display="none";
					this.$("buttonArea").style.display="block";
					this.$("artwork").style.display="block";
					this.$("picTips").style.visibility="visible"
				}else{
					this.$("picTips").style.display="none";
					this.$("openTips").style.display="block";
					this.$("buttonArea").style.display="none";
					this.$("artwork").style.display="none";
					this.$("picTips").style.visibility="hidden"
				}
				this.$("openTips").style.visibility="visible";
				var b=/<.*?>|s|(&nbsp;)/g;
				if(photoJson[a].showtit){
					this.$("titleArea").innerHTML='<p class="phot-desp">'+photoJson[a].showtit.replace(b,"")+"</span>&nbsp;<span>("+(a+1)+"/"+Number(this.Count)+")</span></p>"
				}else{
					/*
					this.$("picTips").style.display="none";this.$("buttonArea").style.display="none";this.$("openTips").style.display="none"
					*/
					this.$("titleArea").innerHTML='<p class="phot-desp">'+"&nbsp;<span>("+(a+1)+"/"+Number(this.Count)+")</span></p>";
				}
				if(photoJson[a].showtxt){
					this.$("contTxt").innerHTML="<p align='center' style='margin:3px auto;line-height:22px;'>"+photoJson[a].showtxt+"</p>"
				}
		},opchangShow:function(a,b,c,d){if(this.ops<=b){if(this.isIE){a.filters.alpha.opacity=this.ops;a.filters.alpha.finishopacity=100}else{a.style.opacity=this.ops/100}this.ops+=c;setTimeout(function(){picShow.opchangShow(a,b,c,d)},d)}else{this.ops=0}
		},GetCurrentStyle:function(a,b){if(a.currentStyle){return a.currentStyle[b]}else{if(window.getComputedStyle){b=b.replace(/([A-Z])/g,"-$1");b=b.toLowerCase();return window.getComputedStyle(a,"").getPropertyValue(b)}}return null
		},DargS:function(){
		},DargU:function(a){a=window.event||a;a.cancelBubble=true;picShow.isIE?picShow.$("scrollbar-in").releaseCapture():window.releaseEvents(a.MOUSEMOVE|a.MOUSEUP);removeEventHandler(picShow.$("scrollbar-in"),"mousemove",picShow.DargM);picShow.$("scrollbar-in").onmousemove=null;picShow.downallS()
		},DargM:function(a){a=window.event||a;a.cancelBubble=true;picShow.DargPos(a.clientX-picShow.posX)},DargPos:function(a){a=Math.max(0,Math.min(a,386));picShow.$("scrollbar-in").style.left=a-picShow.Mleft+"px";picShow.downall()
		},Loader:function(){
			for(var a=0;a<this.Count;a++){
				this.Src[a]=photoJson[a].bigpic
			}
			
			picShow.$("Display").style.filter="alpha(opacity:0)";
			picShow.$("Display").style.opacity=0;
			this.Now=this.RequestNowCount();
			this.showSmallImageReload("smallPhoto");
			this.viewJump(this.Now-1);
			this.$("smallPhoto").style.width=88*this.Count+"px";
			this.Mleft=parseInt(this.GetCurrentStyle(picShow.$("scrollbar-in"),"margin-left"))||0;
			if(this.Count>6){addEventHandler(picShow.$("scrollbar-in"),"mouseup",picShow.DargU);
			if(!picShow.isIE){addEventHandler(picShow.$("scrollbar-in"),"mouseout",picShow.DargU)}
			addEventHandler(picShow.$("scrollbar-in"),"mousedown",function(b){var event=window.event||b;picShow.posX=event.clientX-parseInt(picShow.$("scrollbar-in").offsetLeft);if(picShow.isIE){picShow.$("scrollbar-in").setCapture()}else{window.captureEvents(event.MOUSEMOVE|event.MOUSEUP);event.preventDefault()}addEventHandler(picShow.$("scrollbar-in"),"mousemove",picShow.DargM)})}
			addEventHandler(picShow.$("buttonArea"),"click",function(){
								picShow.$("picTips").style.display="none";
								picShow.$("buttonArea").style.display="none";
								picShow.$("artwork").style.display="none";
								picShow.$("picTips").style.visibility="hidden";
								picShow.$("openTips").style.display="block";
								Cookieset("oPENtIPS","hidden")
							});
			addEventHandler(picShow.$("openTips"),"click",function(){
								picShow.$("picTips").style.display="block";
								picShow.$("openTips").style.display="none";
								picShow.$("buttonArea").style.display="block";
								picShow.$("artwork").style.display="block";
								picShow.$("picTips").style.visibility="visible";
								Cookieset("oPENtIPS","show");
							});
			addEventHandler(picShow.$("artwork"),"click",function(){
								var url = 'http://pic.766.com/view.html?url='+picShow.$("artwork").href;
								window.open(url);
							});
			addEventHandler(picShow.$("preArrow"),"mousemove",function(){picShow.$("preArrow").style.cursor="url(http://mat1.gtimg.com/news/2009hd/arr_left.cur),auto"});
			addEventHandler(picShow.$("nextArrow"),"mousemove",function(){picShow.$("nextArrow").style.cursor="url(http://mat1.gtimg.com/news/2009hd/arr_right.cur),auto"});
			addEventHandler(picShow.$("preArrow"),"click",function(){picShow.viewPrev()});addEventHandler(picShow.$("nextArrow"),"click",function(){picShow.viewNext()});
			addEventHandler(picShow.$("Up"),"click",function(){picShow.viewPrev()});
			addEventHandler(picShow.$("Down"),"click",function(){picShow.viewNext()});
			/*
			addEventHandler(picShow.$("mainArea"),"mouseover",function(){
							if(Cookieget("oPENtIPS")!==null){
								//if(Cookieget("oPENtIPS")=="hidden"&&photoJson[picShow.Now].showtit){
								if(Cookieget("oPENtIPS")=="hidden"){
									picShow.$("openTips").style.display="block";
									picShow.$("openTips").style.visibility="visible"
								}
							}
						});
			addEventHandler(picShow.$("mainArea"),"mouseout",function(){
							if(Cookieget("oPENtIPS")!==null){
								//if(Cookieget("oPENtIPS")=="hidden"&&photoJson[picShow.Now].showtit){
								if(Cookieget("oPENtIPS")=="hidden"){
									picShow.$("openTips").style.display="none";
									picShow.$("openTips").style.visibility="hidden"
								}
							}
						});
			*/
			addEventHandler(document,"keydown",function(b){b=window.event||b;b.keyCode==37&&picShow.viewPrev(parseInt(picShow.Now));b.keyCode==39&&picShow.viewNext()})},pushNext:function(){var a=Number(this.Now)+1;if(this.Count>1&&this.Count>a){this.Img.src=this.Src[a]}},pushPrev:function(){var a=Number(this.Now)-1;if(this.Count>1&&a>0){this.Img.src=this.Src[a]}},RequestNowCount:function(){var a=window.document.location.href,b=a.indexOf("/");a=a.substr(b+1).split("#");for(b=0;b<a.length;b++){var c=a[b].split("=");if(c[0].toUpperCase()==this.Mark.toUpperCase()){return Number(c[1])}}return Number(0)},viewJump:function(a){this.Now=a;if(a>0&&a<this.Count){this.Now=a;this.Display("next",a)}else{this.Now=0;this.Display("next",0)}picShow.lastGoto("close")
			
		},viewPrev:function(){picShow.lastGoto("close");if(this.Now>0){this.Now--;window.location.href="#p="+(this.Now+1);this.showSmallImageReload("smallPhoto");this.Display("prev",this.Now);this.pushPrev(this.Now)}else{this.Now!=0&&this.viewJump(this.Count-1)}},viewNext:function(){if(this.Now<this.Count-1){this.Now++;window.location.href="#p="+(this.Now+1);this.showSmallImageReload("smallPhoto");this.Display("next",this.Now);picShow.lastGoto("close")}else{if(this.Now==this.Count-1){picShow.lastGoto("open");return false}else{this.viewJump(0);picShow.lastGoto("close")}}},PageRe:function(a){var b=this.Now,c=Math.ceil((b+1)/6),d=Number(this.Count);(c<1||b>=d)&&(c=1);if(a=="next"){if(c*6<this.Count){this.viewJump(c*6);this.$("Up").className="photo-Up";this.$("Down").className="photo-Down";if(parseInt(Math.ceil(this.Count/6)-1)<=c){this.$("Down").className="photo-Down";this.$("Down").title="向后";this.$("Up").className="photo-Up"}}}else{if(this.Now<=6){this.Now!==0&&this.viewJump(0)}else{this.viewJump((c-1)*6-6);this.$("Up").className="photo-Up";this.$("Down").className="photo-Down"}}},showSmallImageReload:function(a){var b=this.$(a).innerHTML="",c=document.createElement("li");parseInt(this.Now);for(var d=Number(this.Count),f=new Image,e=0;e<d;e++){f.src=photoJson[e].smallpic;c.innerHTML=f.width>f.height?"<div onclick='picShow.viewJump("+e+")'><span class='imgs'><img src="+photoJson[e].smallpic+" width='78' alt='点击欣赏第"+(e+1)+"张图片'/></span><span class='titles'>"+(e+1)+"<em>&nbsp;/ "+d+"</em></span></div>":"<div onclick='picShow.viewJump("+e+")'><span class='imgs'><img src="+photoJson[e].smallpic+" alt='点击欣赏第"+(e+1)+"张图片' /></span><span class='titles'>"+(e+1)+"<em>&nbsp;/ "+d+"</em></span></div>";this.$(a).appendChild(c);b+=this.$(a).innerHTML}this.$(a).innerHTML=b},scrollFuc:function(a){var b=this.$("smallPhoto").getElementsByTagName("li");if(picShow.Now==0||picShow.Now*88-Math.abs(picShow.$("smallPhoto").offsetLeft)==176||picShow.Now>=Number(picShow.Count-3)){if(picShow.timerMe!=0){clearInterval(picShow.timerMe);picShow.$("noDiv").style.display="none";picShow.timerMe=0}if(oldObj){oldObj.className=""}b[picShow.Now].className="photo-Select";oldObj=b[picShow.Now];if(this.Now<Number(this.Count-3)){picShow.$("scrollbar-in").style.left=picShow.$("smallPhoto").offsetLeft+picShow.Now*88+"px"}}else{if(a=="down"){picShow.$("smallPhoto").style.left=parseInt(Math.floor(picShow.$("smallPhoto").offsetLeft)-8,10)+"px"}else{picShow.$("smallPhoto").style.left=parseInt(Math.floor(picShow.$("smallPhoto").offsetLeft)+8,10)+"px"}}
		},showSmallImageStatic:function(a){a=this.$(a).getElementsByTagName("li");var b=-Math.floor(picShow.$("smallPhoto").offsetLeft/88);if(picShow.timerMe!=0){clearInterval(picShow.timerMe);picShow.$("noDiv").style.display="none";picShow.timerMe=0}if(this.Now==0){this.tmpLeft=0;picShow.$("smallPhoto").style.left="0px";if(oldObj){oldObj.className=""}a[this.Now].className="photo-Select";oldObj=a[this.Now];picShow.$("scrollbar-in").style.left=picShow.Now*88+"px"}else{if(this.tmpLeft==0){this.tmpLeft=parseInt(picShow.$("smallPhoto").offsetLeft,10)}if(this.Now>=b+3){if(this.Now>=this.Count-3&&this.Count>6){if(oldObj){oldObj.className=""}a[picShow.Now].className="photo-Select";oldObj=a[picShow.Now];picShow.$("smallPhoto").style.left=-parseInt(picShow.Count-6)*88+"px";picShow.$("scrollbar-in").style.left=parseInt(picShow.Now*88)+picShow.$("smallPhoto").offsetLeft+"px"}else{picShow.timerMe=setInterval("picShow.scrollFuc('down')",20)}}else{if(this.Now>3){picShow.timerMe=setInterval("picShow.scrollFuc('up')",20)}else{picShow.$("smallPhoto").style.left="0px";if(oldObj){oldObj.className=""}a[picShow.Now].className="photo-Select";oldObj=a[picShow.Now];picShow.$("scrollbar-in").style.left=picShow.Now*88+"px"}}}
		},downall:function(){var a=parseInt(88*(picShow.$("scrollbar-in").offsetLeft/(528-picShow.$("scrollbar-in").offsetWidth))*(this.Count-6));picShow.$("smallPhoto").style.left=-a+"px"},downallS:function(){clearInterval(picShow.timerMe);picShow.timerMe=setInterval(function(){var a=parseInt(picShow.$("smallPhoto").offsetLeft);if(a%88==0){clearInterval(picShow.timerMe);picShow.$("noDiv").style.display="none"}else{picShow.$("noDiv").style.display="block";a-=1;picShow.$("smallPhoto").style.left=a+"px"}},1)}};Object.beget=function(a){var b=function(){};b.prototype=a;return new b};function creatIF(){var a=document.createElement("iframe");a.id="iframeP";a.name="iframeP";a.style.display="none";a.width="0px";a.height="0px";picShow.$("PGViframe").appendChild(a)}function btraceZhiboPv(){g_btrace_zhibo=new Image(1,1);var a=trimUin(pgvGetCookieByName("o_cookie="));g_btrace_zhibo.src="#";if(typeof pgvMain=="function"){pvRepeatCount=1;pgvMain()}}function addCount(a){if(typeof pgvMain=="function"){pvRepeatCount=1;pgvMain()}if(picShow.$("iframeP")||a!==0){/*统计地址 a="http://"+picShow.SiteName+".766.com/niersen_tongji.htm?"+a; */a=a;if(picShow.isIE){document.all.iframeP.contentWindow.location=''}else{picShow.$("iframeP").src=a}}}addEventHandler(window,"load",creatIF);