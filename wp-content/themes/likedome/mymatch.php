<?php
/*
 Template Name: My Match
 */
?>
<?php  get_header();?>
<div class="vsCon">
	<div id="tab5">
		<div class="title">
			<h3 class="fl">我的比赛</h3>
			<ul class="tab_menu flo margin-t6 margin-l80">
				<li class="select">
					我参加的
				</li>
				<li>
					我关注的
				</li>
			</ul>
		</div>
		<div class="flo margin-l30 width-610">
			<?php if ( 0 == $current_user->ID ) : ?>
				你尚未登陆
			<?php else : ?>
			<div class="tab_main">
				<ul class="joinList margin-t13" style="width: 100%; float: left;">
					<?php $users = getUserList($current_user->ID, -1, -1, -1, 1);
						if(count($users)) : foreach ($users as $user) {
							$args = get_match_post($user->match_id);
							query_posts($args);
							if (have_posts()) : while (have_posts()) : the_post(); ?>
					<li style="width: 100%; float: left;">
						<a href="?p=77&matchid=<?php  echo $user->match_id; ?>"><?php  the_post_thumbnail();?></a>
						<dl>
							<?php the_excerpt(); ?>
							<dd class="join margin-t10">
								<?php 
								get_follow_match_button($current_user -> ID, $user->match_id); ?>
							</dd>
						</dl>
						<div class="clear"></div>
					</li>
					<?php endwhile; endif; }; wp_reset_postdata(); else : ?>
					<li style="width: 100%; float: left;">
						* 目前你还没有参加过任何比赛
					</li>
					<?php endif; ?>
				</ul>
			</div>
			<div class="tab_main">
				<ul class="joinList margin-t13" style="width: 100%; float: left;">
					<?php $users = getUserList($current_user->ID, -1, -1, 1);
						if(count($users)) : foreach ($users as $user) {
							$args = get_match_post($user->match_id);
							query_posts($args);
							if (have_posts()) : while (have_posts()) : the_post(); ?>
					<li style="width: 100%; float: left;">
						<a href="?p=77&matchid=<?php echo $user->match_id; ?>"><?php  the_post_thumbnail(); ?></a>
						<dl>
							<?php the_excerpt(); ?>
							<dd class="join margin-t10">
								<?php $matchs = getMatchList($user->match_id);
								get_apply_match_button($current_user -> ID, $user->match_id, $matchs[0]->stage); ?>
							</dd>
						</dl>
						<div class="clear"></div>
					</li>
					<?php  endwhile; endif; }; wp_reset_postdata(); else : ?>
					<li style="width: 100%; float: left;">
						* 目前你还没有关注过任何比赛
					</li>
					<?php endif; ?>
				</ul>
			</div>
			<div class="vs-relat">
				<span>相关链接：</span><a href="#">注册会员</a><a href="#">选手认证</a><a href="#">平台比赛</a><a href="#">比赛论坛</a>
			</div>
		<?php endif; ?>
		</div>
	</div>
	<div class="fro margin-r30 margin-t13 width-231 joinGame">
		<div class="joinGame-show textOver">
			<h5 class="textOver">参赛流程图</h5>
		</div>
	</div>
</div>
<?php get_footer(); ?>