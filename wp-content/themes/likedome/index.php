<?php get_header(); 
	if($_POST['matchTypeList'] == "所有比赛") {
		$_POST['matchTypeList'] = null;
	}
?>
<div class="margin-l18 flo width-600">
    <div id="tab">
        <div class="title">
            <h3 class="flo margin-l12">查看<?php echo $_POST['matchTypeList']; ?></h3>
            <div class="kind flo">
            	<form name= "matchTypeSelect" action= "" method= "post">
	                <select name="matchTypeList" onChange= "document.matchTypeSelect.submit();">
	                	<?php 
	                		$matchTypeId = 0;
	                		if(!empty($_POST['matchTypeList'])) {
	                			echo '<option>'.$_POST['matchTypeList'].'</option>';
							}
							echo '<option>所有比赛</option>';
			                $related = $wpdb->get_results("
			                SELECT id, type
			                FROM {$wpdb->prefix}likedome_match_type
			                LIMIT 10");
			                if ( $related ) {
			                    foreach ($related as $related_post) {
			                    	if(!empty($_POST['matchTypeList']) && ($related_post->type == $_POST['matchTypeList'])) {
			                    		$matchTypeId = $related_post->id;
			                    		continue;
									}
			                    	echo '<option>'.$related_post->type.'</option>';
								}
							}
			            ?>
			            <?php wp_reset_postdata(); ?>
	                </select>
                </form>
            </div>
            <ul class="tab_menu fro margin-t6 padding-r6"><li class="select">全部比赛</li><li>正在进行中</li><li>报名中</li><li>比赛结束</li></ul>
        </div>
        <div class="tab_main">
        	<?php $querySql = "SELECT id FROM {$wpdb->prefix}likedome_match";
				if(!empty($_POST['matchTypeList']) && !empty($matchTypeId)) {
	            	$querySql.=" WHERE type=".$matchTypeId;
				}
	            $related = $wpdb->get_results($querySql." ORDER BY id DESC LIMIT 4"); // 显示4条
				$count = 0;
	            if ( $related ) {
	                foreach ($related as $related_post) {
						$matchPostIds = $wpdb->get_results("SELECT post_id FROM {$wpdb->prefix}postmeta WHERE meta_key = '链接比赛' AND meta_value = '{$related_post->id}' LIMIT 10");
						$args = array(
	                        'category__in' => array(16), // 包括的分类ID
	                        'post__in' => $matchPostIds['post_id'],
	                        'showposts' => 1, // 显示相关文章数量
	                        'caller_get_posts' => 1
                    	);
						query_posts($args);
						if (have_posts()) : while (have_posts()) : the_post();
							if($count == 0){ 
								$count++; ?>
								<div class="margin-t10 tabimg">
									<a href="<?php the_permalink(); ?>" target="_blank" class="fl" title="<?php the_title_attribute(); ?>" ><?php the_post_thumbnail(); ?></a>
								</div>
								<h4 class="margin-t6 margin-b10"><?php the_title_attribute(); ?></h4>
								<dl class="margin-t10 tablist">
									<?php the_excerpt(); ?>
									<dd class="margin-t13 join">
										<a class="btn margin-r10 fl" href="比赛页面.html">点击参加</a><a class="btn margin-r10 fl" href="#">关注比赛</a><span class="margin-r10 fl">30人参加</span><span class="margin-r10 fl">180人关注</span>
										<!--<span class="margin-r10 fl listen height-23"><a style="color:#222; font-weight:bold;" href="#">小天</a></span> <a href="#" class="fl" style="color:#3a8dc9;">立即收听</a>-->
										<div id="txWB_W1"></div>
										<script type="text/javascript">
											var tencent_wb_name = "likedo545336";
											var tencent_wb_sign = "0b559270946bf9185b42b093de5d6d1e6a8bbe86";
											var tencent_wb_style = "3";
										</script><!-- <script type="text/javascript" src="http://v.t.qq.com/follow/widget.js" charset="utf-8"/> --></script>
									</dd>
								</dl>
								<ul class="joinList margin-t13 border-t">
							<?php } else { ?>
								<li> <a href="比赛页面.html" target="_blank"><?php the_post_thumbnail(); ?></a>
				                    <dl>
				                        <?php  the_excerpt();  ?>
				                        <dd class="join margin-t10"> <a href="比赛页面.html" target="_blank" class="btn margin-r10 fl">点击参加</a> </dd>
				                    </dl>
				                    <div class="clear"></div>
				                </li>
							<?php } endwhile; ?>
							</ul>
						<?php 
						endif;
					}
				} ?>
	        <?php wp_reset_postdata(); ?>
            <div class="clear"></div>
        </div>
		<!-- 正在进行中 -->
        <div class="tab_main">
            <ul class="joinList margin-t2">
                <li> <a href="比赛页面.html" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/pic/01.jpg" /></a>
                    <dl>
                        <dt>来动网与农大第一界羽毛球公开赛赛</dt>
                        <dd>报名时间：4月8日 周四 03:00 - 4月18日 周日 23:00</dd>
                        <dd>比赛时间：5月8日 周四 03:00 - 5月18日 周日 23:00</dd>
                        <dd>比赛类别：羽毛球</dd>
                        <dd>首轮赛制：单淘汰</dd>
                        <dd>比赛场地：福州省体育</dd>
                        <dd class="join margin-t10"> <a href="比赛页面.html" target="_blank" class="btn margin-r10 fl">点击参加</a> </dd>
                    </dl>
                    <div class="clear"></div>
                </li>
                <li> <a href="比赛页面.html" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/pic/01.jpg" /></a>
                    <dl>
                        <dt>来动网与农大第一界羽毛球公开赛</dt>
                        <dd>报名时间：4月8日 周四 03:00 - 4月18日 周日 23:00</dd>
                        <dd>比赛时间：5月8日 周四 03:00 - 5月18日 周日 23:00</dd>
                        <dd>比赛类别：羽毛球</dd>
                        <dd>首轮赛制：单淘汰</dd>
                        <dd>比赛场地：福州省体育</dd>
                        <dd class="join margin-t10"> <a href="比赛页面.html" target="_blank" class="btn margin-r10 fl">点击参加</a> </dd>
                    </dl>
                    <div class="clear"></div>
                </li>
                <li> <a href="比赛页面.html" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/pic/01.jpg" /></a>
                    <dl>
                        <dt>来动网与农大第一界羽毛球公开赛</dt>
                        <dd>报名时间：4月8日 周四 03:00 - 4月18日 周日 23:00</dd>
                        <dd>比赛时间：5月8日 周四 03:00 - 5月18日 周日 23:00</dd>
                         <dd>比赛类别：羽毛球</dd>
                        <dd>首轮赛制：单淘汰</dd>
                        <dd>比赛场地：福州省体育</dd>
                        <dd class="join margin-t10"> <a href="比赛页面.html" target="_blank" class="btn margin-r10 fl">点击参加</a> </dd>
                    </dl>
                    <div class="clear"></div>
                </li>
                <li> <a href="比赛页面.html" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/pic/01.jpg" /></a>
                    <dl>
                        <dt>来动网与农大第一界羽毛球公开赛</dt>
                        <dd>报名时间：4月8日 周四 03:00 - 4月18日 周日 23:00</dd>
                        <dd>比赛时间：5月8日 周四 03:00 - 5月18日 周日 23:00</dd>
                         <dd>比赛类别：羽毛球</dd>
                        <dd>首轮赛制：单淘汰</dd>
                        <dd>比赛场地：福州省体育</dd>
                        <dd class="join margin-t10"> <a href="比赛页面.html" target="_blank" class="btn margin-r10 fl">点击参加</a> </dd>
                    </dl>
                    <div class="clear"></div>
                </li>
                <li> <a href="比赛页面.html" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/pic/01.jpg" /></a>
                    <dl>
                        <dt>来动网与农大第一界羽毛球公开赛</dt>
                        <dd>报名时间：4月8日 周四 03:00 - 4月18日 周日 23:00</dd>
                        <dd>比赛时间：5月8日 周四 03:00 - 5月18日 周日 23:00</dd>
                         <dd>比赛类别：羽毛球</dd>
                        <dd>首轮赛制：单淘汰</dd>
                        <dd>比赛场地：福州省体育</dd>
                        <dd class="join margin-t10"> <a href="比赛页面.html" target="_blank" class="btn margin-r10 fl">点击参加</a> </dd>
                    </dl>
                    <div class="clear"></div>
                </li>
                <li> <a href="比赛页面.html" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/pic/01.jpg" /></a>
                    <dl>
                        <dt>来动网与农大第一界羽毛球公开赛</dt>
                        <dd>报名时间：4月8日 周四 03:00 - 4月18日 周日 23:00</dd>
                        <dd>比赛时间：5月8日 周四 03:00 - 5月18日 周日 23:00</dd>
                         <dd>比赛类别：羽毛球</dd>
                        <dd>首轮赛制：单淘汰</dd>
                        <dd>比赛场地：福州省体育</dd>
                        <dd class="join margin-t10"> <a href="比赛页面.html" target="_blank" class="btn margin-r10 fl">点击参加</a> </dd>
                    </dl>
                    <div class="clear"></div>
                </li>
            </ul>
            <div class="clear"></div>
            <div class="pageNo margin-t18"><span class="firstpage"><a href="#">首页</a></span><span class="prepage"><a href="#">上一页</a></span><a href="#">1</a><strong>2</strong><a href="#">3</a><a href="#">4</a><a href="#">5</a><a href="#">6</a>...<a href="#">20</a><span class="nextpage"><a href="#">下一页</a></span><span class="lastpage"><a href="#">尾页</a></span></div>
        </div>
        <div class="tab_main">
            <ul class="joinList margin-t2">
                <li> <a href="比赛页面.html" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/pic/01.jpg" /></a>
                    <dl>
                        <dt>来动网与农大第一界羽毛球公开赛</dt>
                        <dd>报名时间：4月8日 周四 03:00 - 4月18日 周日 23:00</dd>
                        <dd>比赛时间：5月8日 周四 03:00 - 5月18日 周日 23:00</dd>
                         <dd>比赛类别：羽毛球</dd>
                        <dd>首轮赛制：单淘汰</dd>
                        <dd>比赛场地：福州省体育</dd>
                        <dd class="join margin-t10"> <a href="比赛页面.html" target="_blank" class="btn margin-r10 fl">点击参加</a> </dd>
                    </dl>
                    <div class="clear"></div>
                </li>
                <li> <a href="比赛页面.html" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/pic/01.jpg" /></a>
                    <dl>
                        <dt>来动网与农大第一界羽毛球公开赛</dt>
                        <dd>报名时间：4月8日 周四 03:00 - 4月18日 周日 23:00</dd>
                        <dd>比赛时间：5月8日 周四 03:00 - 5月18日 周日 23:00</dd>
                        <dd>比赛类别：羽毛球</dd>
                        <dd>首轮赛制：单淘汰</dd>
                        <dd>比赛场地：福州省体育</dd>
                        <dd class="join margin-t10"> <a href="比赛页面.html" target="_blank" class="btn margin-r10 fl">点击参加</a> </dd>
                    </dl>
                    <div class="clear"></div>
                </li>
                <li> <a href="比赛页面.html" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/pic/01.jpg" /></a>
                    <dl>
                        <dt>来动网与农大第一界羽毛球公开赛</dt>
                        <dd>报名时间：4月8日 周四 03:00 - 4月18日 周日 23:00</dd>
                        <dd>比赛时间：5月8日 周四 03:00 - 5月18日 周日 23:00</dd>
                        <dd>比赛类别：羽毛球</dd>
                        <dd>首轮赛制：单淘汰</dd>
                        <dd>比赛场地：福州省体育</dd>
                        <dd class="join margin-t10"> <a href="比赛页面.html" target="_blank" class="btn margin-r10 fl">点击参加</a> </dd>
                    </dl>
                    <div class="clear"></div>
                </li>
                <li> <a href="比赛页面.html" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/pic/01.jpg" /></a>
                    <dl>
                        <dt>来动网与农大第一界羽毛球公开赛</dt>
                        <dd>报名时间：4月8日 周四 03:00 - 4月18日 周日 23:00</dd>
                        <dd>比赛时间：5月8日 周四 03:00 - 5月18日 周日 23:00</dd>
                        <dd>比赛类别：羽毛球</dd>
                        <dd>首轮赛制：单淘汰</dd>
                        <dd>比赛场地：福州省体育</dd>
                        <dd class="join margin-t10"> <a href="比赛页面.html" target="_blank" class="btn margin-r10 fl">点击参加</a> </dd>
                    </dl>
                    <div class="clear"></div>
                </li>
                <li> <a href="比赛页面.html" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/pic/01.jpg" /></a>
                    <dl>
                        <dt>来动网与农大第一界羽毛球公开赛</dt>
                        <dd>报名时间：4月8日 周四 03:00 - 4月18日 周日 23:00</dd>
                        <dd>比赛时间：5月8日 周四 03:00 - 5月18日 周日 23:00</dd>
                        <dd>比赛类别：羽毛球</dd>
                        <dd>首轮赛制：单淘汰</dd>
                        <dd>比赛场地：福州省体育</dd>
                        <dd class="join margin-t10"> <a href="比赛页面.html" target="_blank" class="btn margin-r10 fl">点击参加</a> </dd>
                    </dl>
                    <div class="clear"></div>
                </li>
                <li> <a href="比赛页面.html" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/pic/01.jpg" /></a>
                    <dl>
                        <dt>来动网与农大第一界羽毛球公开赛</dt>
                        <dd>报名时间：4月8日 周四 03:00 - 4月18日 周日 23:00</dd>
                        <dd>比赛时间：5月8日 周四 03:00 - 5月18日 周日 23:00</dd>
                        <dd>比赛类别：羽毛球</dd>
                        <dd>首轮赛制：单淘汰</dd>
                        <dd>比赛场地：福州省体育</dd>
                        <dd class="join margin-t10"> <a href="比赛页面.html" target="_blank" class="btn margin-r10 fl">点击参加</a> </dd>
                    </dl>
                    <div class="clear"></div>
                </li>
            </ul>
            <div class="clear"></div>
            <div class="pageNo margin-t18"><span class="firstpage"><a href="#">首页</a></span><span class="prepage"><a href="#">上一页</a></span><a href="#">1</a><strong>2</strong><a href="#">3</a><a href="#">4</a><a href="#">5</a><a href="#">6</a>...<a href="#">20</a><span class="nextpage"><a href="#">下一页</a></span><span class="lastpage"><a href="#">尾页</a></span></div>
        </div>
        <div class="tab_main">
            <ul class="joinList margin-t2">
                <li> <a href="比赛页面.html" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/pic/01.jpg" /></a>
                    <dl>
                        <dt>来动网与农大第一界羽毛球公开赛</dt>
                        <dd>报名时间：4月8日 周四 03:00 - 4月18日 周日 23:00</dd>
                        <dd>比赛时间：5月8日 周四 03:00 - 5月18日 周日 23:00</dd>
                         <dd>比赛类别：羽毛球</dd>
                        <dd>首轮赛制：单淘汰</dd>
                        <dd>比赛场地：福州省体育</dd>
                        <dd class="join margin-t10"> <a href="比赛页面.html" target="_blank" class="btn margin-r10 fl">点击参加</a> </dd>
                    </dl>
                    <div class="clear"></div>
                </li>
                <li> <a href="比赛页面.html" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/pic/01.jpg" /></a>
                    <dl>
                        <dt>来动网与农大第一界羽毛球公开赛</dt>
                        <dd>报名时间：4月8日 周四 03:00 - 4月18日 周日 23:00</dd>
                        <dd>比赛时间：5月8日 周四 03:00 - 5月18日 周日 23:00</dd>
                         <dd>比赛类别：羽毛球</dd>
                        <dd>首轮赛制：单淘汰</dd>
                        <dd>比赛场地：福州省体育</dd>
                        <dd class="join margin-t10"> <a href="比赛页面.html" target="_blank" class="btn margin-r10 fl">点击参加</a> </dd>
                    </dl>
                    <div class="clear"></div>
                </li>
                <li> <a href="比赛页面.html" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/pic/01.jpg" /></a>
                    <dl>
                        <dt>来动网与农大第一界羽毛球公开赛</dt>
                        <dd>报名时间：4月8日 周四 03:00 - 4月18日 周日 23:00</dd>
                        <dd>比赛时间：5月8日 周四 03:00 - 5月18日 周日 23:00</dd>
                       <dd>比赛类别：羽毛球</dd>
                        <dd>首轮赛制：单淘汰</dd>
                        <dd>比赛场地：福州省体育</dd>
                        <dd class="join margin-t10"> <a href="比赛页面.html" target="_blank" class="btn margin-r10 fl">点击参加</a> </dd>
                    </dl>
                    <div class="clear"></div>
                </li>
                <li> <a href="比赛页面.html" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/pic/01.jpg" /></a>
                    <dl>
                        <dt>来动网与农大第一界羽毛球公开赛</dt>
                        <dd>报名时间：4月8日 周四 03:00 - 4月18日 周日 23:00</dd>
                        <dd>比赛时间：5月8日 周四 03:00 - 5月18日 周日 23:00</dd>
                       <dd>比赛类别：羽毛球</dd>
                        <dd>首轮赛制：单淘汰</dd>
                        <dd>比赛场地：福州省体育</dd>
                        <dd class="join margin-t10"> <a href="比赛页面.html" target="_blank" class="btn margin-r10 fl">点击参加</a> </dd>
                    </dl>
                    <div class="clear"></div>
                </li>
                <li> <a href="比赛页面.html" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/pic/01.jpg" /></a>
                    <dl>
                        <dt>来动网与农大第一界羽毛球公开赛</dt>
                        <dd>报名时间：4月8日 周四 03:00 - 4月18日 周日 23:00</dd>
                        <dd>比赛时间：5月8日 周四 03:00 - 5月18日 周日 23:00</dd>
                        <dd>比赛类别：羽毛球</dd>
                        <dd>首轮赛制：单淘汰</dd>
                        <dd>比赛场地：福州省体育</dd>
                        <dd class="join margin-t10"> <a href="比赛页面.html" target="_blank" class="btn margin-r10 fl">点击参加</a> </dd>
                    </dl>
                    <div class="clear"></div>
                </li>
                <li> <a href="比赛页面.html" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/pic/01.jpg" /></a>
                    <dl>
                        <dt>来动网与农大第一界羽毛球公开赛</dt>
                        <dd>报名时间：4月8日 周四 03:00 - 4月18日 周日 23:00</dd>
                        <dd>比赛时间：5月8日 周四 03:00 - 5月18日 周日 23:00</dd>
                       <dd>比赛类别：羽毛球</dd>
                        <dd>首轮赛制：单淘汰</dd>
                        <dd>比赛场地：福州省体育</dd>
                        <dd class="join margin-t10"> <a href="比赛页面.html" target="_blank" class="btn margin-r10 fl">点击参加</a> </dd>
                    </dl>
                    <div class="clear"></div>
                </li>
            </ul>
            <div class="clear"></div>
            <div class="pageNo margin-t18"><span class="firstpage"><a href="#">首页</a></span><span class="prepage"><a href="#">上一页</a></span><a href="#">1</a><strong>2</strong><a href="#">3</a><a href="#">4</a><a href="#">5</a><a href="#">6</a><a href="#">20</a><span class="nextpage"><a href="#">下一页</a></span><span class="lastpage"><a href="#">尾页</a></span></div>
        </div>
    </div>
    <div class="title margin-t13">
        <h3 class="flo">选手风采</h3>
        <code class="fro margin-r10"><a href="?cat=10">更多选手</a></code>
        <div class="clear"></div>
    </div>
    <ul class="playerList">
    	<?php wp_reset_postdata(); ?>
    	<?php $queryObject = new WP_Query('posts_per_page=4&cat=10');
        if ($queryObject->have_posts()) : while ($queryObject->have_posts()) :$queryObject->the_post();?>
        <li><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
            <div class="icon-camara"></div>
        </li>
        <?php endwhile; endif;?>
        <?php wp_reset_postdata(); ?>
    </ul>
    <div class="clear"></div>
</div>
<?php get_sidebar(); ?>

<?php get_footer(); ?>
