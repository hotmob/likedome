<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head profile="http://gmpg.org/xfn/11">
        <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
        <title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>
        <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" media="screen" />
        <?php
        $icon = get_option(PADD_NAME_SPACE . '_favicon_url', '');
        if (!empty($icon)) {
            echo '<link rel="shortcut icon" href="' . $icon . '" />' . "\n";
            echo '<link rel="icon" href="' . $icon . '" />' . "\n";
        }

        //wp_enqueue_script('jquery');
        //wp_enqueue_script('jquery-ui-tabs');
        //wp_enqueue_script('jquery-cookie', get_template_directory_uri() . '/js/jquery.cookie.js');
        //wp_enqueue_script('jquery-superfish', get_template_directory_uri() . '/js/jquery.superfish.js');
        //wp_enqueue_script('jquery-nivo', get_template_directory_uri() . '/js/jquery.nivo.js');
        //wp_enqueue_script('main-loading', get_template_directory_uri() . '/js/main.loading.js');

        wp_enqueue_script('jquery-min', get_template_directory_uri() . '/js/jquery-1.6.2.min.js');
        wp_enqueue_script('js-simple', get_template_directory_uri() . '/js/js_simple.js');
        wp_enqueue_script('call', get_template_directory_uri() . '/js/call.js');
        wp_enqueue_script('base-platform', get_template_directory_uri() . '/js/platForm766.js');
        wp_enqueue_script('base-platform-login', get_template_directory_uri() . '/js/paltForm766_login.js');
        wp_enqueue_script('jquery-thumb-scroll', get_template_directory_uri() . '/js/jquery.thumbScroll.js');
        ?>
        <?php
        if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
        wp_head(); 
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
    </head>

    <body>
        <div class="body-t">	
            <div class="fbg">		
                <div class="head wrapper">
                    <div class="site flo">
                        <p class="flo">福州站</p>
                    </div>
                    <div class="login fro" id="platFrom766_login"></div>
                </div>
                <div class="clear"></div>
                <div class="wrapper nav">
                    <div class="fl">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'main',
                            'container' => null
                        ));
                        ?>

                    </div>
                    <code class="fr"><a class="margin-r10" href="javascript:void(0)" onclick="simple.setHomePage(this)">设为首页</a><a class="margin-r10" href="javascript:void(0)" onclick="simple.addFavorite()">收藏本站</a></code>
                    <div class="clear"></div>
                </div>

                <?php if (is_home()) : ?>
                    <div class="wrapper2 height-297 flash">
                        <!--<script language="javascript" src="http://image2.766.com/res/skin/2008/js/focus.js?width=961&height=297&files=files&links=links&texts=texts&eval=1&flash=http://image2.766.com/res/skin/2008/js/focus.swf"></script>-->
                        <div class="thumbScroll">
                            <div class="sShow"></div>
                            <ul class="sImg">
                                <li><a href="?page_id=77" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/pic/pic1.jpg" /></a></li>
                                <li><a href="?page_id=77" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/pic/pic2.jpg" /></a></li>
                                <li><a href="?page_id=77" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/pic/pic1.jpg" /></a></li>
                                <li><a href="?page_id=77" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/pic/pic2.jpg" /></a></li>
                                <li><a href="?page_id=77" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/pic/pic1.jpg" /></a></li>
                                <li><a href="?page_id=77" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/pic/pic2.jpg" /></a></li>
                                <li><a href="?page_id=77" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/pic/pic1.jpg" /></a></li>
                            </ul>
                            <div class="sText"> <a href="#" class="sLeft">左</a>
                                <div class="sThumb">
                                    <ul>
                                        <li><img src="<?php echo get_template_directory_uri(); ?>/pic/pic1.jpg" /></li>
                                        <li><img src="<?php echo get_template_directory_uri(); ?>/pic/pic2.jpg" /></li>
                                        <li><img src="<?php echo get_template_directory_uri(); ?>/pic/pic1.jpg" /></li>
                                        <li><img src="<?php echo get_template_directory_uri(); ?>/pic/pic2.jpg" /></li>
                                        <li><img src="<?php echo get_template_directory_uri(); ?>/pic/pic1.jpg" /></li>
                                        <li><img src="<?php echo get_template_directory_uri(); ?>/pic/pic2.jpg" /></li>
                                        <li><img src="<?php echo get_template_directory_uri(); ?>/pic/pic1.jpg" /></li>
                                    </ul>
                                </div>
                                <a href="#" class="sRight">右</a> </div>
                        </div>
                    </div>
                <?php endif; ?>
                    <div class="wrapper2 padding-t13">
                        



