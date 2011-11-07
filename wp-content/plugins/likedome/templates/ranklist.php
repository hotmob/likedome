<?php global $tpl; 
$currentMatchTypeId = $tpl->getVar('currentType');
$rankTypeList  = $tpl->getVar('rankTypeList');
$userRankList  = $tpl->getVar('userRankList'); ?>
<table width="100%" border="0" cellspacing="1" cellpadding="0">
  <tr>
    <td width="10%">
    	<form name= "currentSelect" method= "post">
            <select name="currentTypeSelect" id="currentTypeSelect" onChange="document.currentSelect.submit();" >
                <?php drawMatchTypeSelect($currentMatchTypeId, 0); ?>
            </select>
        </form>
    </td>
    <td width="3%">添加分类</td>
    <td width="17%">
    	<form method= "post">
	    	<input name="matchTypeId" type="hidden" value="<?php echo $currentMatchTypeId; ?>" />
	    	<input name="category" type="hidden" value="addRankType" />
	      	<input name="rankName" type="text" id="rankName" value="例如：助攻" style="width:80px;"/>
	      	<input type="submit" name="submit" id="submit" value="提交" />
      	</form>
    </td>
    <td width="40%">查找队员：
    	<form name= "currentRankSelect" method= "post">
	        <input name="username" type="text" id="username" value="输入队员账号" />
	        <input name="category" type="hidden" value="getUserRank" />
	        <input type="submit" name="button12" id="button12" value="搜索" />
        </form>
    </td>
    <td width="3%">删除分类</td>
    <td width="17%">
    	<form name= "currentRankSelect" method= "post">
    		<select name="currentRankTypeSelect" id="currentRankTypeSelect" onChange="document.currentRankSelect.submit();">
				<?php drawRankListSelect(-1, $tpl->getVar('currentRankTypeSelect'), $rankTypeList); ?>
    		</select>
	    	<input name="category" type="hidden" value="delRankType" />
        	<input type="submit" name="submit" id="submit" value="提交" />
    	</form>
    </td>
  </tr>
</table>
  <table class="widefat" style="line-height:30px;">
    <thead>
      <tr>
      	<th width="3%">ID</th>
        <th width="3%">排名</th>
        <th width="10%">队员</th>
        <th width="10%">账号</th>
		<?php foreach ($rankTypeList as $rankType) {
			echo '<th width="8%">'.$rankType->name.'</th>';
		}?>
        <th width="35%">添加分类自动生成在这里，数据提交上的分类取决于这里</th>
        <th width="35%">&nbsp;</th>
      </tr>
    </thead>
    <tbody id="manage_polls2">
      <?php 
      	$usersRanks = getUserRankList(-1, $currentMatchTypeId, -1, -1, 1, -1, ARRAY_A); // ARRAY_A | ARRAY_N | OBJECT | OBJECT_K
      	$columns = array(1);
      	foreach ($usersRanks as $userRanks) {
      		 array_push($columns, $userRanks['uid'] );
      	}
      	foreach ($userRankList as $user) : 
		$ranking =	array_keys($columns, $user->uid, true);
      	?>
      <tr id="poll-5" class="highlight">
      	<form method= "post">
        <td><?php echo $user->uid; ?></td>
        <td><?php echo $ranking[0]; ?></td>
        <td><?php $userprofile = getUserProfile($user->uid); echo $userprofile[0]->realname; ?></td>
        <td><?php $wpuser = get_user_by('id', $user->uid);  echo $wpuser->user_login; ?></td>
        <?php foreach ($rankTypeList as $rankType) {
        	$userRanks = getUserRankList($user->uid, $currentMatchTypeId, $rankType->id);
			echo '<td><input name="rank-'.$rankType->id.'" type="text" id="rank-'.$rankType->id.'" style="width:60px;" value="'.$userRanks[0]->value.'" /></td>';
		}?>
        <td>
        	<input name="userId" type="hidden" value="<?php echo $user->uid; ?>" />
        	<input name="matchTypeId" type="hidden" value="<?php echo $currentMatchTypeId; ?>" />
	    	<input name="category" type="hidden" value="updateRank" />
        	<input type="submit" name="submit" id="submit" value="提交" />
        </td>
        <td>&nbsp;</td>
        </form>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>