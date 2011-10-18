//JS版本
document.write('<div id="flashCff"><a style="left: 1px ! important; top: 0px ! important;" title="点击这里使 Adblock Plus 过滤该对象" class="abp-objtab-09304596634080645 visible ontop" href="http://static.766.com/newspics/flash/loadingAs3.swf"></a><embed tplayername="SWF" splayername="SWF" type="application/x-shockwave-flash" src="http://static.766.com/newspics/flash/loadingAs3.swf" mediawrapchecked="true" allowfullscreen="true" allownetworking="all" profileport="0" profile="0" seamlesstabbing="1" embedmovie="0" devicefont="0" scale="NoBorder" allowscriptaccess="always" menu="true" quality="High" loop="true" play="true" wmode="Transparent" _cy="5080" _cx="5080" pluginspage="http://www.macromedia.com/go/getflashplayer" id="picMe" name="picMeFF" height="1" width="1"></div><div id="contTxt"></div><div id="PGViframe"></div>');
var GroupjsUrl = "http://static.766.com/newspics/js/hd_min_v1.0.0_utf8.js";//小图缓动版本http://mat1.gtimg.com/news/2009hd/pack/hdPic_new_pack_v1.1.8.js
var mainDiv = document.getElementById("photo-warp");
/*********公用方法*********/
var Ajax_766=function(url,callback){
	var xmlHttp;this.url=url;
	this.callback=callback;
	this.createXMLHttpRequest=function(){
		if(window.ActiveXObject){
			xmlHttp=new ActiveXObject("Microsoft.XMLHTTP")
		}else if(window.XMLHttpRequest){
				xmlHttp=new XMLHttpRequest()
		}
	};
	this.startRequest=function(){
		this.createXMLHttpRequest();
		try{
			xmlHttp.onreadystatechange=function(){
										if(xmlHttp.readyState==4){
											if(xmlHttp.status==200||xmlHttp.status==0){
												var result=xmlHttp.responseText;
												window.setTimeout(callback(result),50);
											}
										}
									};
			xmlHttp.open("GET",this.url,true);
			xmlHttp.setRequestHeader("If-Modified-Since","0");
			xmlHttp.setRequestHeader("Cache-Control","no-cache");
			xmlHttp.setRequestHeader("Charset","GB2312");
			xmlHttp.send(null)
		}catch(exception){
				alert("无法连接服务器!请稍后再试!")
		}
	};
	this.startRequest()
}

function trim(str){return str.replace(/(^\s*)|(\s*$)/g, "");}
function parseURL(url) {  
    var a =  document.createElement('a');  
    a.href = url;  
    return {  
        source: url,  
        protocol: a.protocol.replace(':',''),  
        host: a.hostname,  
        port: a.port,  
        query: a.search,  
        params: (function(){  
            var ret = {},  
                seg = a.search.replace(/^\?/,'').split('&'),  
                len = seg.length, i = 0, s;  
            for (;i<len;i++) {  
                if (!seg[i]) { continue; }  
                s = seg[i].split('=');  
                ret[s[0]] = s[1];  
            }  
            return ret;  
        })(),  
        file: (a.pathname.match(/\/([^\/?#]+)$/i) || [,''])[1],  
        hash: a.hash.replace('#',''),  
        path: a.pathname.replace(/^([^\/])/,'/$1'),  
        relative: (a.href.match(/tps?:\/\/[^\/]+(.+)/) || [,''])[1],  
        segments: a.pathname.replace(/^\//,'').split('/')
    };  
}

function GroupLoadJs(file,callback) {
    try {
            var script = document.createElement('script');
            script.src = file + '#' + Math.random();
            script.type = "text/javascript";
            document.getElementsByTagName("head")[0].appendChild(script);
            if( script.addEventListener ) {
                script.addEventListener("load", callback, false);
            } else if(script.attachEvent) {
                script.attachEvent("onreadystatechange", function(){
                        if(script.readyState == 4
                            || script.readyState == 'complete'
                            || script.readyState == 'loaded') {
                            callback();
                        }
                });
            }
        } catch(e) {
   callback();
        }
 };
/*********公用方法 END*********/

var org = window.location.href;
var photoJson = new Array();
function doit(){
	var arrMe = eval("(" + arguments[0] + ")");
	var length = arrMe.Children[0].Children[0].Children[0].Content;//长度
	for(var i=0;i<length;i++){
		photoJson.push({showtit:''+arrMe.Children[0].Children[1].Children[i].Children[0].Children[0].Content+'', showtxt:''+arrMe.Children[0].Children[1].Children[i].Children[3].Children[0].Content+'', smallpic:''+arrMe.Children[0].Children[1].Children[i].Children[1].Children[0].Content+'', 'bigpic':''+arrMe.Children[0].Children[1].Children[i].Children[2].Children[0].Content+''});
	};
	GroupLoadJs(GroupjsUrl,function(){
		picShow.Picsite="";
		//进入下一组图
		picShow.lastUrl=arrMe.Children[0].Children[2].Content;
		//图片站
		picShow.defatLink = "http://pic.766.com";
		picShow.SiteName = "sports";
		picShow.setTit();
		picShow.Loader();
		picShow.$("photo-warp-inner").style.visibility = "visible";
	});
};
doit(picNew);
var picHtml = '<div class="photo-warp-inner" id="photo-warp-inner" style="visibility: visible;"><div class="mainArea" id="mainArea">'
		     +'<div style="cursor: url(http://static.766.com/newspics/images/arr_left.cur), auto;" id="preArrow" title="上一张"></div><div style="cursor: url(http://static.766.com/newspics/images/arr_right.cur), auto;" id="nextArrow" title="下一张"></div>'
			 +'<div style="display: none;" id="gotolast"></div><div style="display: none;" id="gotolast_inner"><p>已经浏览到最后一张，您可以</p><span href="#" id="rePlay">重新欣赏</span><span id="urlgoto" >下一组图</span></div>'
			 +'<a href="javascript:void(0);" id="bigHref"><img src="" id="Display" style="margin: 0pt auto; cursor: pointer; visibility: visible; opacity: 1;" title="点击浏览下一张" onerr="http://static.766.com/newspics/images/ajax-loader.gif"></a>'
			 +'<div id="loading" style="display: none;"></div><div class="picTips picTips_png" id="picTips" style="display: none; visibility: visible;"><div class="titleArea" id="titleArea"></div>'
			 +'<div class="buttontext"><div  href="javascript:void(0);" class="artwork" id="artwork" title="查看原图">查看原图</div><div style="display: none;" href="javascript:void(0);" class="buttonArea" id="buttonArea" title="隐藏工具栏">隐藏</div></div></div><div class="openTips" id="openTips" title="打开工具栏">工具栏</div>'
			 +'</div><div class="blank001"></div><div class="photoList-wrap"><span class="photo-Up" id="Up" onfocus="this.blur()" title="向前"></span><div class="photo-List" id="photo-List">'
             +'<ul style="left: 0px; width: 2640px;" id="smallPhoto">'
			 +'</ul><div style="display: none;" id="noDiv"></div></div><span class="photo-Down" id="Down" onfocus="this.blur()" title="向后"></span></div>'
			 +'<div id="scrollbar"><span style="left: 0px;" id="scrollbar-in" title="拖动工具条以快速查看图片"></span></div>';
mainDiv.innerHTML = picHtml;


