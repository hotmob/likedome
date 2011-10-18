//loginHtml load
$(function(){
	var platForm766_str = '<div class="login3">'+
		'<p><a href="#">找回密码</a></p>'+
		'<p class="secondPra"><a href="#">立即注册</a></p>'+
	'</div>'+
	'<div class="login2">'+
		'<p>'+
			'<label>账号：</label>'+
			'<input type="text" class="login-text" />'+
			'<input type="checkbox" class="login-check" />'+
			'<label>自动登录</label>'+
		'</p>'+
		'<p class="secondPra">'+
			'<label>密码：</label>'+
			'<input type="text" class="login-text" />'+
			'<input type="button" class="login-btn" value="登录" />'+
		'</p>'+
	'</div>'+
	'<div class="login1">'+
		'<p><a href="#" class="login-tx">用qq账号登录</a></p>'+
		'<p class="secondPra">只需一步快速开始</p>'+
	'</div>'
	document.getElementById("platFrom766_login").innerHTML = platForm766_str;
});

