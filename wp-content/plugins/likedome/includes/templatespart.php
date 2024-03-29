<?php

/**
 * 绘制比赛类型option输出栏目
 */
function drawMatchTypeSelect($currentType = 0, $defaultAll = 1, $matchTypeList = 0) {
	$tmpCurrent = 0;
	if($defaultAll)
		echo '<option value="0">全部比赛</option>';
	if($matchTypeList == 0)
		$matchTypeList = getMatchTypeList();
	foreach($matchTypeList as $matchType){
	    echo '<option  value="'.$matchType->id.'"';
	    if($currentType == $matchType->id) {
	        echo 'selected="selected"';
	    } else if(!$currentType && !$tmpCurrent) {
	    	$tmpCurrent = intval($matchType->id);
	    }
	    echo '>'.$matchType->type.'</option>';
	}
	if($tmpCurrent == 0)
		return $currentType;
	return $tmpCurrent;
}

/**
 * 获取比赛队伍option输出栏目
 */
function getGroupListSelect($matchId, $currentType = 0) {
	$groupList = getGroupList($matchId);
	foreach($groupList as $group){
	    $result.='<option  value="'.$group->id.'"';
	    if($currentType == $group->id) {
	        $result.='selected="selected"';
	    }
	    $result.='>'.$group->name.'</option>';
	}
	return $result;
}

/**
 * 绘制比赛队伍option输出栏目, 返回下一个$currentType值
 */
function drawGroupListSelect($groupList, $currentType = 0) {
	$tmpCurrent = 0;
	foreach($groupList as $group){
	    echo '<option value="'.$group->id.'"';
		if($tmpCurrent == 1)
			$tmpCurrent = intval($group->id);
	    if(intval($currentType) == intval($group->id)) {
	        echo 'selected="selected"';
			$tmpCurrent = 1;
	    }
	    echo '>'.$group->name.'</option>';
	}
	if($tmpCurrent == 0)
		return $groupList[0]->id;
	return $tmpCurrent;
}

/**
 * 绘制比分类型option输出栏目, 返回下一个$currentType值
 */
function drawRankListSelect($matchTypeId = 0, $currentType = 0, $rankTypeList = 0) {
	if($rankTypeList == 0)
		$rankTypeList = getRankTypeList(-1, $matchTypeId);
	foreach($rankTypeList as $rankType){
	    echo '<option  value="'.$rankType->id.'"';
	    if($currentType == $rankType->id) {
	        echo 'selected="selected"';
	    }
	    echo '>'.$rankType->name.'</option>';
	}
}

/**
 * 绘制比赛队伍对阵图
 */
function drawScheduleList($groups, $mid = -1, $rid = -1, $ngid = -1, $sgid = -1, $round='', $begin='', $end='', $result='', $id = 0) {  ?>
	<tr id="poll-5" class="highlight">
		<form name= "currentSelect" method= "post">
			<td>
				<select name="ngid" id="ngid">
					<?php $count = drawGroupListSelect($groups, $ngid); 
						  if($sgid < 0)
						  	$sgid = $count;
					?>
				</select>
			</td>
			<td>VS</td>
			<td>
				<select name="sgid" id="sgid">
					<?php $count = drawGroupListSelect($groups, $sgid); ?>
				</select>
			</td>
			<td><input name="round" type="text" id="round" style="width: 80px;" value="<?php echo $round; ?>" /></td>
			<td><input name="begin" type="text" id="begin" style="width: 180px;" value="<?php echo $begin; ?>" /></td>
			<td><input name="end" type="text" id="end" style="width: 180px;" value="<?php echo $end; ?>" /></td>
			<td><input name="result" type="text" id="result" style="width: 180px;" value="<?php echo $result; ?>" /></td>
			<td>
				<input name="rid" type="hidden" value="<?php echo $rid; ?>" />
				<input name="matchid" type="hidden" value="<?php echo $mid; ?>" />
				<input name="category" type="hidden" value="addschedule" />
				<input type="submit" value="提交" />
			</td>
			<td>
				<?php if($id != 0) : ?>
				<input name="id" type="hidden" value="<?php echo $id; ?>" />
				<input name="category" type="hidden" value="delschedule" />
				<input type="submit" value="删除" />
				<?php endif; ?>
			</td>
		</form>
	</tr>
	<?php
	return $count;
}
?>