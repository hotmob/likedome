<?php get_header(); ?>
<div class="margin-l18 flo width-600">
    <div id="tab">
        <div class="title">
            <h3 class="flo margin-l12">查看</h3>
            <div class="kind flo">
            	<form name= "matchTypeSelect" action= "" method= "post">
	                <select name="currentMatchTypeId" onChange= "document.matchTypeSelect.submit();">
	                	<?php $currentTypeId = intval($_POST['currentMatchTypeId']); drawMatchTypeSelect($currentTypeId); ?>
	                </select>
                </form>
            </div>
            <ul class="tab_menu fro margin-t6 padding-r6"><li class="select">全部比赛</li><li>正在进行中</li><li>报名中</li><li>比赛结束</li></ul>
        </div>
        <div class="tab_main">
        	<?php
				if($currentTypeId != 0)
					$matchList = getMatchList(-1, $currentTypeId, -1, 4);
				else
	            	$matchList = getMatchList(-1, -1, -1, 4);
				$count = 0;
	            if (count($matchList)) : foreach ($matchList as $match) {
                    	$args = get_match_post($match->id);
						query_posts($args);
						if (have_posts()) : while (have_posts()) : the_post();
							if($count == 0){ 
								$count++; ?>
								<div class="margin-t10 tabimg">
									<a href="?p=77&matchid=<?php echo $match->id; ?>" target="_blank" class="fl" title="<?php the_title_attribute(); ?>" >
										<?php 
										$imageContent = get_content_image();
										if(!empty($imageContent)){
											echo "<img src=".$imageContent." />";
										} else {
											the_post_thumbnail();
										} ?></a>
								</div>
								<h4 class="margin-t6 margin-b10"><?php the_title_attribute(); ?></h4>
								<dl class="margin-t10 tablist">
									<?php the_excerpt(); ?>
									<dd class="margin-t13 join">
										<?php get_apply_match_button($current_user->ID, $match->id, $match->stage); ?>
										<?php get_follow_match_button($current_user->ID, $match->id); ?>
										<span class="margin-r10 fl"><?php echo count(getUserList(-1, $match->id, -1, -1, 1)); ?>人参加</span><span class="margin-r10 fl"><?php echo count(getUserList(-1, $match->id, -1, 1)); ?>人关注</span>
										<!--<span class="margin-r10 fl listen height-23"><a style="color:#222; font-weight:bold;" href="#">小天</a></span> <a href="#" class="fl" style="color:#3a8dc9;">立即收听</a>-->
										<div id="txWB_W1"></div>
										<script type="text/javascript">
											var tencent_wb_name = "likedo545336";
											var tencent_wb_sign = "0b559270946bf9185b42b093de5d6d1e6a8bbe86";
											var tencent_wb_style = "3";
										</script><!-- <script type="text/javascript" src="http://v.t.qq.com/follow/widget.js" charset="utf-8"/> --></script>
									</dd>
								</dl>
								<ul class="joinList margin-t2">
							<?php } else { ?>
								<li> <a href="?p=77&matchid=<?php echo $match->id; ?>" target="_blank"><?php the_post_thumbnail(); ?></a>
				                    <dl>
				                        <?php  the_excerpt();  ?>
				                        <?php get_apply_match_button($current_user->ID, $match->id, $match->stage); ?>
				                    </dl>
				                    <div class="clear"></div>
				                </li>
							<?php } endwhile; wp_reset_postdata(); ?>
						<?php 
						endif;
					}
				endif; ?>
				</ul>
            <div class="clear"></div>
        </div>
		<!-- 正在进行中 -->
        <div class="tab_main">
			<?php index_matchType_content($currentTypeId, 2); ?>
            <div class="clear"></div>
        </div>
        <!-- 报名中  -->
        <div class="tab_main">
        	<?php index_matchType_content($currentTypeId, 1); ?>
            <div class="clear"></div>
        </div>
        <!-- 比赛结束  -->
        <div class="tab_main">
            <?php index_matchType_content($currentTypeId, 3); ?>
            <div class="clear"></div>
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
