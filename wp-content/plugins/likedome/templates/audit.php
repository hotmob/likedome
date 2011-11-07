<?php
global $tpl;
$currentMatchTypeId = $tpl->getVar ( 'currentType' );
$rankTypeList = $tpl->getVar ( 'rankTypeList' );
$userRankList = $tpl->getVar ( 'userRankList' );
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0">
	<tr>
		<td width="5%">
			<form name="currentSelect" method="post">
				<select name="currentTypeSelect" id="currentTypeSelect"
					onChange="document.currentSelect.submit();">
                <?php drawMatchTypeSelect($currentMatchTypeId, 0); ?>
            </select>
			</form>
		</td>
		<td width="1%">
		</td>
		<td width="4%">&nbsp;</td>
		<td>
	    	<form name= "currentRankSelect" method= "post">
		        <input name="username" type="text" id="username" value="输入队员账号" />
		        <input name="category" type="hidden" value="getUserRank" />
		        <input type="submit" name="button12" id="button12" value="搜索" />
	        </form>
        </td>
	</tr>
</table>
<table class="widefat" style="line-height: 30px;">
	<thead>
		<tr>
			<th width="3%">ID</th>
			<th width="3%">队员</th>
			<th width="10%">账号</th>
			<?php foreach ($rankTypeList as $rankType) {
				echo '<th width="8%">'.$rankType->name.'</th>';
			}?>
			<th width="10%">审核</th>
			<th width="20%">比赛名称</th>
		</tr>
	</thead>
	<tbody id="manage_polls2">
	    <?php foreach ($userRankList as $user) : ?>
		<tr id="poll-5" class="highlight">
		<form method= "post">
			<td><?php echo $user->uid; ?></td>
        	<td><?php $userprofile = getUserProfile($user->uid); echo $userprofile[0]->realname; ?></td>
        	<td><?php $wpuser = get_user_by('id', $user->uid);  echo $wpuser->user_login; ?></td>
			<?php foreach ($rankTypeList as $rankType) {
	        	$userRanks = getUserRankList($user->uid, $currentMatchTypeId, $rankType->id);
				echo '<td>'.$userRanks[0]->value.'</td>';
			}?>
			<td>
	        	<input name="submitId" type="hidden" value="<?php echo $user->submitId; ?>" />
	        	<input name="userId" type="hidden" value="<?php echo $user->uid; ?>" />
	        	<input name="matchTypeId" type="hidden" value="<?php echo $currentMatchTypeId; ?>" />
		    	<input name="category" type="hidden" value="update" />
	        	<input type="submit" name="submit" id="submit" value="审核" />
        	</td>
			<td><?php
				if($user->submitId) {
					$userRankApplys = getUserRankApplyList($user->submitId);
				 	if(intval($userRankApplys)){
				 		$groups = getGroupList($scheduleList[0]->mid, OBJECT_K);
				 		$scheduleList = getScheduleList($userRankApplys[0]->scheduleId);
				 		echo $groups[$scheduleList[0]->sgid]->name." Vs ".$groups[$scheduleList[0]->ngid]->name."  /  ";
				 		echo $scheduleList[0]->begin." ".$scheduleList[0]->end." 论次:".$scheduleList[0]->round;
				 	}
				} else {
					echo "系统生成";
				}
			?></td>
		</form>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>