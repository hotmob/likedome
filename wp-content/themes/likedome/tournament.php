<?php
/*
 Template Name: tournament
 */
?>
<?php  get_header();
	$matchid = intval($_REQUEST['matchid']); 
	if($matchid > 0) 
		$accept = intval(getMatchList($matchid));
	$require_login = 1;
	if($current_user->ID == 0) 
		$require_login = 0;
	if($accept && $require_login)
		$users = getUserList($current_user->ID, $matchid); 
?>
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
					微博管理
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
					战绩提交
				</li>
				<li>
					创建队伍
				</li>
				<li>
					队伍管理
				</li>
			</ul>
		</div>
		<div class="flo margin-l30 width-610">
			<!--比赛相关-->
			<div class="tab_main">
				<?php if(!$accept) {
					echo '<div style="width:360px; height:200px; line-height:200px; font-family:\'微热雅黑\'; font-size:30px; text-align:center; margin:20px auto; border:8px solid #e8e8e8; color:#333; background: #FDFDFD;">权限错误或没有登陆</div>';
				} else{ ?>
					<div class="width-600 margin-t18">
						<?php  query_posts(get_match_post($matchid, 16));
						if (have_posts()) :
							while (have_posts()) : the_post();
								echo '<h4 class="margin-t10 vs-h4">';
								the_title_attribute();
								echo '</h4>';
								the_content();
							endwhile;
						else :
							echo '没有内容输出';
						endif; wp_reset_query(); ?>
					</div>
				<?php } ?>
			</div>
			<!--比赛规则-->
			<div class="tab_main">
				<?php if(!$accept) {
					echo '<div style="width:360px; height:200px; line-height:200px; font-family:\'微热雅黑\'; font-size:30px; text-align:center; margin:20px auto; border:8px solid #e8e8e8; color:#333; background: #FDFDFD;">权限错误或没有登陆</div>';
				} else{ ?>
					<div class="width-600 margin-t18">
						<?php  query_posts(get_match_post($matchid, 14));
						if (have_posts()) :
							while (have_posts()) : the_post();
								echo '<h4 class="margin-t10 vs-h4">';
								the_title_attribute();
								echo '</h4>';
								the_content();
							endwhile;
						else :
							echo '没有内容输出';
						endif; wp_reset_query(); ?>
					</div>
				<?php } ?>
			</div>
			<!--比赛奖励-->
			<div class="tab_main">
				<?php if(!$accept) {
					echo '<div style="width:360px; height:200px; line-height:200px; font-family:\'微热雅黑\'; font-size:30px; text-align:center; margin:20px auto; border:8px solid #e8e8e8; color:#333; background: #FDFDFD;">权限错误或没有登陆</div>';
				} else{ ?>
					<div class="width-600 margin-t18">
						<?php  query_posts(get_match_post($matchid, 15));
						if (have_posts()) :
							while (have_posts()) : the_post();
								echo '<h4 class="margin-t10 vs-h4">';
								the_title_attribute();
								echo '</h4>';
								the_content();
							endwhile;
						else :
							echo '没有内容输出';
						endif; wp_reset_query(); ?>
					</div>
				<?php } ?>
			</div>
			<!--微博管理-->
			<div class="tab_main">
				<?php if(!$accept) {
					echo '<div style="width:360px; height:200px; line-height:200px; font-family:\'微热雅黑\'; font-size:30px; text-align:center; margin:20px auto; border:8px solid #e8e8e8; color:#333; background: #FDFDFD;">权限错误或没有登陆</div>';
				} else{ ?>
					<div class="wraningText margin-t22 font-size14">
						没登陆腾讯微博的登陆后，点击收听并按F5刷新页面
					</div>
					<div class="width-600 margin-t18">
						<?php  query_posts(get_match_post($matchid, 17));
						if (have_posts()) :
							while (have_posts()) : the_post();
								echo '<h4 class="margin-t10 vs-h4">';
								the_title_attribute();
								echo '</h4>';
								the_content();
							endwhile;
						else :
							echo '还没有结束的比赛';
						endif; wp_reset_query(); ?>
					</div>
				<?php } ?>
			</div>
			<!--队伍查询-->
			<div class="tab_main font-size141">
				<?php if(!$require_login || !$accept) {
					echo '<div style="width:360px; height:200px; line-height:200px; font-family:\'微热雅黑\'; font-size:30px; text-align:center; margin:20px auto; border:8px solid #e8e8e8; color:#333; background: #FDFDFD;">权限错误或没有登陆</div>';
				} else{ ?>
					<dl class="vs-group margin-t18"><?php
						if(!empty($users)) {
							$grouplist = getGroupList($matchid);
							if (count($grouplist)) : foreach ($grouplist as $group) { ?>
						<dt>
								<?php  echo $group -> name;?>
						</dt>
						<dd>
								队长：<?php if(!intval($group->captain_id)) echo '系统管理员'; echo(get_user_by('id', $group->captain_id) -> user_login);?>
						</dd>
						<dd>
								队员：<?php  $userList = getUserList(-1, $matchid, $group -> id);
								foreach ($userList as $player) {
									echo get_user_by('id', $player -> uid) -> user_login . "; ";
								};
								echo '</br>';
								if (intval($users[0]->apply_group)) {
									echo "本次比赛中你只能申请加入一个队伍.";
								} else {
									echo "<a onclick=\"showWindowsFrameTimer('applygroup','wp-content/plugins/likedome/tournament.php?opt=applygroup&matchid=" . $matchid . "&groupid=" . $group -> id . "', 1500);\" href=\"#\">申请加入</a>";
								} ?>
						</dd><?php  
							} 
							else:
							echo '还没有比赛队伍,快来创建吧!';
							endif; 
						} else {
							echo '你还未参加这次比赛';
						}
						?>
					</dl>
				<?php } ?>
			</div>
			<!--对阵查询-->
			<div class="tab_main">
				<?php if(!$require_login || !$accept) {
					echo '<div style="width:360px; height:200px; line-height:200px; font-family:\'微热雅黑\'; font-size:30px; text-align:center; margin:20px auto; border:8px solid #e8e8e8; color:#333; background: #FDFDFD;">权限错误或没有登陆</div>';
				} else{ ?>
					<div class="width-600 margin-t18">
						<?php $scheduleList = getScheduleList(-1, $matchid); $groups = getGroupList($matchid, OBJECT_K);
						if (!empty($scheduleList)) : 
							echo '<table width="100%" border="1" cellspacing="0" cellpadding="0">';
							echo '<tr><td width="15%" height="24" align="center">队伍</td>
									    <td width="15%" height="24" align="center">队伍</td>
									    <td width="10%" height="24" align="center">场次</td>
									    <td width="20%" height="24" align="center">开始</td>
									    <td width="20%" align="center">结束</td>
									    <td width="20%" align="center">结果</td>
								  </tr>';
							foreach ($scheduleList as $schedule) : ?>
							<tr>
								<td width="15%" height="24" align="center"><?php echo $groups[$schedule->sgid]->name; ?></td>
							    <td width="15%" height="24" align="center"><?php echo $groups[$schedule->ngid]->name; ?></td>
							    <td width="10%" height="24" align="center"><?php echo $schedule->round; ?></td>
							    <td width="20%" height="24" align="center"><?php echo $schedule->begin; ?></td>
							    <td width="20%" align="center"><?php echo $schedule->end; ?></td>
							    <td width="20%" align="center"><?php echo $schedule->result; ?></td>
							</tr>
							<?php endforeach;
							echo '</table>';
						else :
							echo '比赛尚未开始或者对阵内容尚未分配;';
						endif;
						wp_reset_query();
						?>
					</div>
				<?php } ?>
			</div>
			<!--成绩查询-->
			<div class="tab_main font-size14">
				<?php if(!$require_login || !$accept) {
					echo '<div style="width:360px; height:200px; line-height:200px; font-family:\'微热雅黑\'; font-size:30px; text-align:center; margin:20px auto; border:8px solid #e8e8e8; color:#333; background: #FDFDFD;">权限错误或没有登陆</div>';
				} else{ ?>
					<div class="width-600 margin-t18">
						<?php $scheduleList = getScheduleList(-1, $matchid, -1, intval($users[0]->group_id)); $groups = getGroupList($matchid, OBJECT_K);
						if (!empty($scheduleList)) : 
							echo '<table width="100%" border="1" cellspacing="0" cellpadding="0">';
							echo '<tr><td width="15%" height="24" align="center">队伍</td>
									    <td width="15%" height="24" align="center">队伍</td>
									    <td width="10%" height="24" align="center">场次</td>
									    <td width="20%" height="24" align="center">开始</td>
									    <td width="20%" align="center">结束</td>
									    <td width="20%" align="center">结果</td>
								  </tr>';
							foreach ($scheduleList as $schedule) : ?>
							<tr>
								<td width="15%" height="24" align="center"><?php echo $groups[$schedule->sgid]->name; ?></td>
							    <td width="15%" height="24" align="center"><?php echo $groups[$schedule->ngid]->name; ?></td>
							    <td width="10%" height="24" align="center"><?php echo $schedule->round; ?></td>
							    <td width="20%" height="24" align="center"><?php echo $schedule->begin; ?></td>
							    <td width="20%" align="center"><?php echo $schedule->end; ?></td>
							    <td width="20%" align="center"><?php echo $schedule->result; ?></td>
							</tr>
							<?php endforeach;
							echo '</table>';
						else :
							echo '没有查找到与您相关的比赛成绩;';
						endif;
						wp_reset_query();
						?>
					</div>
				<?php } ?>
			</div>
			<!--战绩提交-->
			<div class="tab_main font-size14">
				<?php if(!$require_login || !$accept) {
					echo '<div style="width:360px; height:200px; line-height:200px; font-family:\'微热雅黑\'; font-size:30px; text-align:center; margin:20px auto; border:8px solid #e8e8e8; color:#333; background: #FDFDFD;">权限错误或没有登陆</div>';
				} else{ ?>
					<div class="wraningText margin-t22">
						友情提醒：本平台会对数据进行审核一旦发现作假，将会适当对其进行相关处罚。
					</div>
					<div class="width-600 margin-t18">
						<?php $scheduleList = getScheduleList(-1, $matchid, -1, intval($users[0]->group_id)); $groups = getGroupList($matchid, OBJECT_K);
						if (!empty($scheduleList)) : foreach ($scheduleList as $schedule) : ?>
							<p><?php echo $groups[$schedule->sgid]->name." Vs ".$groups[$schedule->ngid]->name ?></p>
							<p><?php echo $schedule->begin." ".$schedule->end." 论次:".$schedule->round; ?></p>
							<?php 
							if((!empty($schedule->result)) && (strlen($schedule->result) > 0)) : 
								$userRankApplys = getUserRankApplyList(-1, $current_user->ID, $matchid, $schedule->id);
								if(!empty($userRankApplys) && intval($userRankApplys)){ 
									echo "<p>本场已经提交成绩;</p>";
									if($userRankApplys[0]->verify){
										echo "<p>并已经通过审核,计入总分;</p>";
									}
								} else { 
									$match = getMatchList($matchid);
									$matchTypes = getMatchTypeList(OBJECT_K);
									$rankTypeList = getRankTypeList(-1, $match[0]->type);
									echo "<form method= \"post\" action=\"wp-content/plugins/likedome/tournament.php?opt=ranksubmit&matchid=".$matchid."\" >";
									foreach ($rankTypeList as $rankType) {
										echo '<p>'.$rankType->name.' : <input name="rank-'.$rankType->id.'" type="text" id="rank-'.$rankType->id.'" class="vs-text" value="" /></p>';
									} ?>
									<p>
										<input name="matchId" type="hidden" value="<?php echo $matchid; ?>" />
										<input name="matchTypeId" type="hidden" value="<?php echo $match[0]->type; ?>" />
										<input name="scheduleId" type="hidden" value="<?php echo $schedule->id; ?>" />
										<input type="submit" class="btn3" value="提交" />
									</p>
									<p></p>
							<?php echo "</form>"; } ?>
							<?php else: ?>
							<p><?php echo $schedule->result; ?></p>
							<p>本场比赛尚未结束或未录入成绩,请稍候提交成绩;</p>
							<?php endif; ?>
							<?php endforeach;
						else :
							echo '没有查找到与您相关的比赛成绩;';
						endif;
						wp_reset_query();
						?>
					</div>
				<?php } ?>
			</div>
			<!--创建队伍-->
			<div class="tab_main font-size14">
				<?php if(!$require_login || !$accept) {
					echo '<div style="width:360px; height:200px; line-height:200px; font-family:\'微热雅黑\'; font-size:30px; text-align:center; margin:20px auto; border:8px solid #e8e8e8; color:#333; background: #FDFDFD;">权限错误或没有登陆</div>';
				} else{ ?>
					<div class="width-600 margin-t18"><?php 
						if(empty($users)){
							echo "您还未参加此场比赛";
						} else if (intval($users[0]->apply_group)) {
							echo "您已经申请了其他的队伍!";
						} else {
						?>
						<form name= "currentSelect" method= "post" action="wp-content/plugins/likedome/tournament.php?opt=creategroup&matchid=<?php echo $matchid; ?>">
	                    	<input name="groupname" type="text" id="groupname" value="输入队伍名称" />
	                    	<input type="submit" value="创建队伍" />
	                	</form>
						<?php  }?>
					</div>
				<?php } ?>	
			</div>
			<!--队伍管理-->
			<div class="tab_main font-size14">
				<?php if(!$require_login || !$accept) {
					echo '<div style="width:360px; height:200px; line-height:200px; font-family:\'微热雅黑\'; font-size:30px; text-align:center; margin:20px auto; border:8px solid #e8e8e8; color:#333; background: #FDFDFD;">权限错误或没有登陆</div>';
				} else{ ?>
					<ul class="vs-manage margin-t22">
						<?php // $users = getUserList($current_user -> ID, $matchid);
							if(empty($users)){
								echo "您还未参加此场比赛";
							} else if (intval($users[0]->apply_group)) {
								$groups = getGroupList(-1, $users[0]->group_id); echo '<li>'.$groups[0]->name.'</li>';
								$userList = getUserList(-1, -1, $users[0]->group_id);
								if($groups[0]->captain_id == 0)
									echo '<li><span>队长 : 系统管理员</span>';
						 		foreach ($userList as $groupuser) : 
									$user = get_user_by('id', $groupuser->uid);
									if($groups[0]->captain_id == $current_user->ID) { // 队长模式
										if($groups[0]->captain_id == $groupuser->uid) {
											echo '<li><span>队长 : '.$user->user_login.'</span>';
										} else {
											echo '<li><span>队员 : '.$user->user_login.'</span>';
										}
										if($groupuser->uid != $current_user -> ID) { // 不是自己你
											if(!$groupuser->pass_apply_group){
												echo '<a onclick="showWindowsFrameTimer(\'passapplygroup\', \'wp-content/plugins/likedome/tournament.php?opt=passapplygroup&matchid='.$matchid.'&groupid='.$groupuser->group_id.'&memberid='.$groupuser->uid.'\', 500);" href="#">申请通过</a><a onclick="showWindowsFrameTimer(\'cancelgroup\', \'wp-content/plugins/likedome/tournament.php?opt=cancelgroup&matchid='.$matchid.'&groupid='.$groupuser->group_id.'&memberid='.$groupuser->uid.'\', 500);" href="#">拒绝申请</a></li>';
											} else {
												echo '<a onclick="showWindowsFrameTimer(\'cancelgroup\', \'wp-content/plugins/likedome/tournament.php?opt=cancelgroup&matchid='.$matchid.'&groupid='.$groupuser->group_id.'&memberid='.$groupuser->uid.'\', 500);" href="#">踢出队伍</a></li>';
											}
										}
									} else { // 普通模式
										if($groups[0]->captain_id == $groupuser->uid) {
											echo '<li><span>队长 : '.$user->user_login.'</span>';
										} else {
											echo '<li><span>队员 : '.$user->user_login.'</span>';
										}
										if($groupuser->uid == $current_user -> ID) { // 是自己你
											if(!intval($groupuser->pass_apply_group)){
												echo '状态 : 申请中  ';
											}
											echo '<a onclick="showWindowsFrameTimer(\'cancelgroup\', \'wp-content/plugins/likedome/tournament.php?opt=cancelgroup&matchid='.$matchid.'&groupid='.$groupuser->group_id.'&memberid='.$groupuser->uid.'\', 500);" href="#">离开队伍</a></li>';
										}
									}
								endforeach; 
							} else {
								 echo '你还没有申请加入队伍!';
							} ?>
						<li class="wraningText padding-l80 padding-t10">
							及时提醒客服更新队伍状态，有利于快速完成队伍组建。
							<br />
							本站对恶意操作的队长将给予适当处罚。
						</li>
					</ul>
				<?php } ?>
			</div>
			<!--relat-->
			<div class="clear"></div>
			<div class="vs-relat">
				<span>相关链接：</span><a href="/bbs/member.php?mod=register">注册会员</a><a href="bbs/home.php?mod=spacecp&ac=profile&op=verify">选手认证</a><a onclick="showWindowsFrameTimer('apply_match', 'wp-content/plugins/likedome/tournament.php?opt=apply&matchid=<?php echo $matchid; ?>&flag=1', 500);" >报名参赛</a><a href="bbs/">比赛论坛</a>
			</div>
		</div>
		<div class="fro margin-r30 margin-t13 width-231 joinGame">
			<?php if(intval($matchid)) : ?>
			<h4><span><?php echo count(getUserList(-1, $matchid, -1, -1, 1)); ?>人报名</span><span class="margin-l10"><?php echo count(getUserList(-1, $matchid, -1, 1)); ?>人关注</span></h4>
			<?php endif; ?>
			<?php if($accept) : ?>
			<p class="margin-t6">
				<?php 
					if(intval($users[0]->apply_match)) : ?>
					<a id="frame" class="textOver btn6">已经报名</a></p>
					<!--<a id="frame" onclick="showWindowsFrameTimer('cancelapply_match', 'wp-content/plugins/likedome/tournament.php?opt=cancelapply&matchid=<?php echo $matchid; ?>&flag=1', 500);" class="textOver btn6">取消报名</a></p>-->
				<?php else : ?>
					<a id="frame" onclick="showWindowsFrameTimer('apply_match', 'wp-content/plugins/likedome/tournament.php?opt=apply&matchid=<?php echo $matchid; ?>&flag=1', 500);" class="textOver btn4">我要参赛</a>
				<?php endif; ?>
			</p>
			<p class="margin-t22">
				<?php if(intval($users[0]->apply_follow)) : ?>
					<a id="frame" onclick="showWindowsFrameTimer('cancelapply_match', 'wp-content/plugins/likedome/tournament.php?opt=cancelfollow&matchid=<?php echo $matchid; ?>&flag=1', 500);" class="textOver btn7">取消关注</a></p>
				<?php else : ?>
					<a id="frame" onclick="showWindowsFrameTimer('apply_match', 'wp-content/plugins/likedome/tournament.php?opt=follow&matchid=<?php echo $matchid; ?>&flag=1', 500);" class="textOver btn5">关注比赛</a>
				<?php endif; ?>
			</p>
			<?php endif; ?>
			<div class="joinGame-show textOver">
				<h5 class="textOver">参赛流程图</h5>
			</div>
		</div>
	</div>
</div>
<?php get_footer();?>