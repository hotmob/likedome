<?php

/**
 * 绘制比赛类型option输出栏目
 */
function drawMatchTypeSelect($currentType = 0) {
	echo '<option value="0">全部比赛</option>';
	$matchTypeList = getMatchTypeList();
	foreach($matchTypeList as $matchType){
	    echo '<option  value="'.$matchType->id.'"';
	    if($currentType == $matchType->id) {
	        echo 'selected="selected"';
	    }
	    echo '>'.$matchType->type.'</option>';
	}
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
 * 绘制比赛队伍option输出栏目
 */
function drawGroupListSelect($groupList, $currentType = 0) {
	foreach($groupList as $group){
	    $result.='<option  value="'.$group->id.'"';
	    if($currentType == $group->id) {
	        $result.='selected="selected"';
	    }
	    $result.='>'.$group->name.'</option>';
	}
	return $result;
}
?>