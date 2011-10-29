<?php
/*
 Template Name: tournament
 */
?>
<?php get_header();?>
<div class="vsCon">
	<div id="tab4">
		<div class="title">
			<h3 class="fl">赛事动态</h3>
			<ul class="tab_menu fro margin-t6 margin-r4">
				<li class="select">
					比赛相关
				</li>
				<li>
					比赛规则
				</li>
				<li>
					比赛奖励
				</li>
				<li>
					队伍查询
				</li>
				<li>
					对阵查询
				</li>
				<li>
					成绩查询
				</li>
				<li>
					比赛结果
				</li>
				<li>
					战绩提交
				</li>
				<li>
					创建队伍
				</li>
				<li>
					队伍管理
				</li>
				<li>
					微博管理
				</li>
			</ul>
		</div>
		<div class="flo margin-l30 width-610">
			<?php $matchid = $_REQUEST['matchid']; if( ($matchid != null) && (count(getMatchList($matchid)) > 0)) : ?>
			<!--比赛相关-->
			<div class="tab_main">
				<div class="width-600 height-700 margin-t18">
					<?php query_posts(get_match_post($matchid, 16));
						if (have_posts()) : while (have_posts()) : the_post();
							echo '<h4 class="margin-t10 vs-h4">';
							the_title_attribute();
							echo '</h4>';
							the_content();
						endwhile; else:
							echo '没有内容输出';
						endif;
					wp_reset_query(); ?>
				</div>
			</div>
			<!--比赛规则-->
			<div class="tab_main">
				<div class="width-600 height-700 margin-t18">
					<?php query_posts(get_match_post($matchid, 14));
						if (have_posts()) : while (have_posts()) : the_post();
							echo '<h4 class="margin-t10 vs-h4">';
							the_title_attribute();
							echo '</h4>';
							the_content(); 
						endwhile; else:
							echo '没有内容输出';
						endif;
					wp_reset_query(); ?>
				</div>
			</div>
			<!--比赛奖励-->
			<div class="tab_main">
				<div class="width-600 height-700 margin-t18">
					<?php query_posts(get_match_post($matchid, 15));
						if (have_posts()) : while (have_posts()) : the_post();
							echo '<h4 class="margin-t10 vs-h4">';
							the_title_attribute();
							echo '</h4>';
							the_content(); 
						endwhile; else:
							echo '没有内容输出';
						endif;
					wp_reset_query(); ?>
				</div>
			</div>
			<!--队伍查询-->
			<div class="tab_main font-size14">
				<dl class="vs-group margin-t18">
					<?php $grouplist = getMatchGroupList($matchid);
						if ($grouplist != null) : foreach ($grouplist as $group) { ?>
							<dt><?php echo $group->name; ?></dt>
							<dd>队长：<?php echo (get_user_by('id',$group->captain_id)->user_login); ?></dd>
							<dd>队员：<?php $userList = getGroupUserList($group->id);
								foreach ($userList as $player){
									echo get_user_by('id', $player->user_id)->user_login."; ";
								}; 
								$joinGroupState = getUserGroup($current_user->ID, $group->id);
								if( $joinGroupState == 1) {
									echo "已经加入";
								} else if( $joinGroupState == null) {
									echo "<a onclick=\"showWindowsFrameTimer('applygroup','wp-content/plugins/likedome/tournament.php?opt=applygroup&matchid=".$matchid."&groupid=".$group->id."', 1500);\" href=\"#\">申请加入</a>";
								} else {
									echo "加入审核中";
								}
								?>
							</dd>
					<?php } else:
							echo '还没有比赛队伍,快来创建吧!';
						endif; ?>
				</dl>
			</div>
			<!--对阵查询-->
			<div class="tab_main">
				<div class="width-600 height-700 margin-t18">
					<?php query_posts(get_match_post($matchid, 19));
						if (have_posts()) : while (have_posts()) : the_post();
							echo '<h4 class="margin-t10 vs-h4">';
							the_title_attribute();
							echo '</h4>';
							the_content(); 
						endwhile; else:
							echo '比赛尚未开始或者对阵内容尚未分配;';
						endif;
					wp_reset_query(); ?>
				</div>
			</div>
			<!--成绩查询-->
			<div class="tab_main font-size14">
				<div class="width-600 height-700 margin-t18">
					<?php query_posts(get_match_post($matchid, 19));
						if (have_posts()) : while (have_posts()) : the_post();
							echo '<h4 class="margin-t10 vs-h4">';
							the_title_attribute();
							echo '</h4>';
							the_content(); 
						endwhile; else:
							echo '还没有结束的比赛';
						endif;
					wp_reset_query(); ?>
				</div>
			</div>
			<!--比赛结果-->
			<div class="tab_main font-size14">
				<div class="width-600 height-700 margin-t18">
					<?php query_posts(get_match_post($matchid, 19));
						if (have_posts()) : while (have_posts()) : the_post();
							echo '<h4 class="margin-t10 vs-h4">';
							the_title_attribute();
							echo '</h4>';
							the_content(); 
						endwhile; else:
							echo '还没有结束的比赛';
						endif;
					wp_reset_query(); ?>
				</div>
			</div>
			<!--战绩提交-->
			<div class="tab_main font-size14">
				<div class="wraningText margin-t22">
					友情提醒：本平台会对数据进行审核一旦发现作假，将会适当对其进行相关处罚。
				</div>
				<div class="width-600 height-700 margin-t18">
					<?php query_posts(get_match_post($matchid, 19));
						if (have_posts()) : while (have_posts()) : the_post();
							echo '<h4 class="margin-t10 vs-h4">';
							the_title_attribute();
							echo '</h4>';
							the_content(); 
						endwhile; else:
							echo '只有队长才能提交比赛得分数据.';
						endif;
					wp_reset_query(); ?>
				</div>
			</div>
			<!--创建队伍-->
			<div class="tab_main font-size14">
				<div class="width-600 height-700 margin-t18">
					<?php if (getUserGroup($userid, $groupid) != null) {
						  	echo "您已经申请了其他的队伍!";
						  } else if (getUserApply($userid, $matchid) == NULL){
						  	echo "您还未参加此场比赛";	
						  } else { ?>
						  	<form name= "matchTypeSelect" action= "" method= "post">
						  		<input id="name" name="name" value=""/>
						  	</form>
					<?php } ?>
				</div>
			</div>
			<!--队伍管理-->
			<div class="tab_main font-size14">
				<ul class="vs-manage margin-t22">
					<li>
						斩蛇队伍
					</li>
					<li>
						<span>队员1：队员时刻记分开</span><a href="#">提出队伍</a>
					</li>
					<li>
						<span>队员2：队员时刻记分开</span><a href="#">提出队伍</a>
					</li>
					<li>
						<span>队员3：队员时刻记分开</span><a href="#">提出队伍</a>
					</li>
					<li>
						<span>队员4：队员时刻记分开</span><a href="#">离开队伍</a>
					</li>
					<li>
						<span>队员5：队员时刻记分开</span><a href="#">申请通过</a><a href="#">拒绝申请</a>
					</li>
					<li class="padding-t10">
						<label class="fl width-80">操作理由：</label>
						<textarea></textarea>
					</li>
					<li class="padding-l80">
						<input type="button" class="btn3" value="提出申请" />
					</li>
					<li class="wraningText padding-l80 padding-t10">
						及时提醒客服更新队伍状态，有利于快速完成队伍组建。
						<br />
						本站对恶意操作的队长将给予适当处罚。
					</li>
				</ul>
			</div>
			<!--微博管理-->
			<div class="tab_main">
				<div class="wraningText margin-t22 font-size14">
					没登陆腾讯微博的登陆后，点击收听并按F5刷新页面
				</div>
				<div class="width-600 height-700 margin-t18">
					<?php query_posts(get_match_post($matchid, 17));
						if (have_posts()) : while (have_posts()) : the_post();
							echo '<h4 class="margin-t10 vs-h4">';
							the_title_attribute();
							echo '</h4>';
							the_content(); 
						endwhile; else:
							echo '还没有结束的比赛';
						endif;
					wp_reset_query(); ?>
				</div>
			</div>
			<?php else : ?>
				<div style="height:680px;" >
					<div style="width:360px; height:200px; line-height:200px; font-family:'微热雅黑'; font-size:30px; text-align:center; margin:20px auto; border:8px solid #e8e8e8; color:#333; background: #FDFDFD;">你没有权限查看这个页面</div>
				</div>
			<?php endif; ?>
			<!--relat-->
			<div class="clear"></div>
			<div class="vs-relat">
				<span>相关链接：</span><a href="#">注册会员</a><a href="#">选手认证</a><a onclick="showWindowsFrame('wp-content/plugins/likedome/likedome.php?opt=competition&type=1&flag=1');" >报名参赛</a><a href="#">比赛论坛</a>
			</div>
		</div>
		<div class="fro margin-r30 margin-t13 width-231 joinGame">
			<?php if($_REQUEST['matchid'] != null) : ?>
			<h4><span>30人报名</span><span class="margin-l10">180人关注</span></h4>
			<p class="margin-t6">
				<a id="frame" onclick="showWindowsFrame('wp-content/plugins/likedome/tournament.php?opt=apply&type=1&flag=1');" class="textOver btn4">我要参赛</a>
			</p>
			<!--<p class="margin-t6"><a href="#" class="textOver btn6">取消报名</a></p>-->
			<p class="margin-t22">
				<a href="#" class="textOver btn5">关注比赛</a>
			</p>
			<!--<p class="margin-t22"><a href="#" class="textOver btn7">取消关注</a></p>-->
			<!--<p class="margin-t6"><span class="textOver btn8">报名结束</span></p>-->
			<?php endif; ?>
			<div class="joinGame-show textOver">
				<h5 class="textOver">参赛流程图</h5>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>