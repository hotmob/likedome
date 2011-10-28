//loginHtml load
$(function(){
	var platForm766_str = '<div class="login3">'+
		'<p><a href="bbs/member.php?mod=logging&action=login&viewlostpw=1">找回密码</a></p>'+
		'<p class="secondPra"><a href="bbs/member.php?mod=register">立即注册</a></p>'+
	'</div>'+
	'<form id="lsform" onsubmit="return lsSubmit()" action="bbs/member.php?mod=logging&action=login&loginsubmit=yes&infloat=yes&lssubmit=yes" autocomplete="off" method="post" accept-charset="gbk" onsubmit="document.charset=\'gbk\';">'+
	'<div class="login2">'+
		'<p>'+
			'<label>账号：</label>'+
			'<input id="ls_username" name="username" type="text" class="login-text" />'+
			'<input id="ls_cookietime" type="checkbox" tabindex="903" value="2592000" name="cookietime" class="login-check" />'+
			'<label>自动登录</label>'+
		'</p>'+
		'<p class="secondPra">'+
			'<label>密码：</label>'+
			'<input id="ls_password" type="password" tabindex="902" autocomplete="off" name="password" class="login-text" />'+
			'<input id="reglink_forgotpw" type="submit" initialized="true" class="login-btn" value="登录" />'+
		'</p>'+
	'</div>'+
	'</form>'+
	'<div class="login1">'+
		'<p><a href="bbs/connect.php?mod=login&op=init&referer=http://www.laidongwang.com/&statfrom=login_simple" class="login-tx">用qq账号登录</a></p>'+
		'<p class="secondPra">只需一步快速开始</p>'+
	'</div>'
	document.getElementById("platFrom766_login").innerHTML = platForm766_str;
});

