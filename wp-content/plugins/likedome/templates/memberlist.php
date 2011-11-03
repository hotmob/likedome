<?php   global $tpl;  $group = $tpl->getVar('group'); $members = $tpl->getVar('members'); $groupcurrent = count($members); ?>
<table class="widefat" style="line-height:30px;">
    <thead>
    <?php if (!empty($group)) :  ?>
      <tr>
        <th width="5%">ID</th>
        <th width="20%">队伍名称</th>
        <th width="10%">队长名称</th>
        <th width="10%">最大队员数量</th>
		<th width="10%">目前队员数量</th>
      </tr>
    </thead>
    <tbody id="manage_polls2">
      <tr id="poll-5" class="highlight">
        <td><strong><?php echo $group->id; ?></strong></td>
        <td><strong><?php echo $group->name; ?></strong></td>
        <td><strong><?php if($group->captain_id == 0) {
        									echo '系统管理员';
       									 } else {  $wpuser = get_user_by('id', $group->captain_id);  echo $wpuser->user_login; } ?></strong></td>
        <td><strong><?php echo $group->maxpeople; ?></strong></td>
        <td><strong><?php echo $groupcurrent; ?></strong></td>
      <?php endif; ?>
      </tr>
      <tr id="poll-6" >
        <th>参赛选手</th>
        <th></th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
      </tr>
      <tr id="poll-7" class="alternate">
        <td colspan="5"><table width="100%" border="0" cellspacing="1" cellpadding="0" style="background:#eeeeee;">
          <tr>
            <th width="10%">队伍ID</th>
            <th width="15%">帐号ID</th>
            <th width="15%">登陆账号</th>
            <th width="15%">真实姓名</th>
            <th width="15%">删除用户</th>
          </tr>
          <?php foreach($members as $user) : ?>
          <tr>
            <td><?php echo $user->group_id; ?></td>
            <td><?php echo $user->uid; ?></td>
            <td><?php $userTemp = get_user_by('id', $user->uid);  echo $userTemp->user_login; ?></td>
            <td><?php $userprofile = getUserProfile($user->uid); echo $userprofile[0]->realname; ?></td>
            <td>
            <form name= "currentSelect" method= "post">
				<input name="matchId" type="hidden" value="<?php echo $user->match_id; ?>" />
	        	<input name="userId" type="hidden" value="<?php echo $user->uid; ?>" />
	        	<input name="category" type="hidden" value="del" />
	        	<input type="submit"  value="删除" />
	        </form>
	        </td>
            <td>&nbsp;</td>
          </tr>
          <?php endforeach;  ?>
          <?php if (!empty($group)) :  
         			$notgroupmember = $tpl->getVar('notgroupmember');  ?>
	          <tr>
	            <td colspan="5">本队伍还能添加<?php echo ($group->maxpeople - $groupcurrent); ?>名队员, 还有<?php echo sizeof($notgroupmember); ?>名选手没有找到队伍, 添加队员说明：这里下拉的是没参加队伍只有报名的队员
	            <form name= "currentSelect" method= "post">
	            	<select name="memberId" >
	              	<?php if(sizeof($notgroupmember)) : foreach ($notgroupmember as $user) : ?>
	                <option value="<?php echo $user->uid; ?>" ><?php $userprofile = getUserProfile($user->uid); echo $userprofile[0]->realname; ?></option>
	              	<?php endforeach; ?>
	              	<?php else : ?>
	              		<option>本场比赛没有剩余选手</option>
	              	<?php endif; ?>
	              	</select>
	              	<input name="matchId" type="hidden" value="<?php echo $group->match_id; ?>" />
	              	<input name="groupId" type="hidden" value="<?php echo $group->id; ?>" />
	              	<input name="category" type="hidden" value="joingroup" />
	                <input type="submit"  value="提交" />
	             </form>
	             </td>
	          </tr>
          <?php endif; ?>
        </table></td>
      </tr>
    </tbody>
  </table>