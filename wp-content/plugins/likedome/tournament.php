<?php
### pre_common_member_verify
### e.g. wp-content/plugins/likedome/tournament.php?opt=['methodname']&type=1&flag=1
define( 'LIKEDOME_PLUGINS_ROOT', dirname( __FILE__ ) );

require_once(LIKEDOME_PLUGINS_ROOT.'/includes/classes.php');

tournament();
function tournament () {
	global $wpdb, $user_identity, $user_ID;
	header('Content-Type: text/html; charset='.getCharset().'');
	if(intval($_REQUEST['matchid']) > 0 && intval($_REQUEST['opt']) > 0) {
		echo "参数错误!";
		exit ;
	}
	$matchid = intval($_REQUEST['matchid']);
	if (!empty($user_identity)) {
		$username = htmlspecialchars(addslashes($user_identity));
	} else if(!empty($_COOKIE['comment_author_'.COOKIEHASH])) {
		$username = htmlspecialchars(addslashes($_COOKIE['comment_author_'.COOKIEHASH]));
	} else {
		echo "需要登陆";
		exit ;
	}
	switch($_REQUEST['opt']) {
	case 'apply' :
		if(!getUserVerify($user_ID)) {
			echo "需要选手认证才可以报名";
			exit;
		}
		$apply = $wpdb->query("SELECT verify1 FROM pre_common_member_verify WHERE uid = $user_ID");
		if(count(getUserList($user_ID, $matchid, -1, -1, 1)) > 0) {
			echo "你已经报过名了";
			exit;
		}
		updateUser($user_ID, $matchid, -1, -1, 1);
		if(count(getUserList($user_ID, $matchid, -1, -1, 1)) > 0) {
			echo "报名成功!";
			exit;
		}
		echo "报名时发生错误";
		exit;
	case 'cancelapply' :
		updateUser($user_ID, $matchid, -1, -1, 0);
		echo "报名已取消";
		exit;
	case 'follow' :
		updateUser($user_ID, $matchid, -1, 1);
		if(count(getUserList($user_ID, $matchid, -1, 1)) > 0) {
			echo "关注成功!";
			exit;
		}
		echo "关注时发生错误";
		exit;
	case 'cancelfollow' :
		updateUser($user_ID, $matchid, -1, 0);
		echo "关注已取消";
		exit;
	case 'cancelgroup' :
		$groupid = intval($_REQUEST['groupid']);
		$memberid = intval($_REQUEST['memberid']);
		$users = getUserList($memberid);
		if(empty($users)){
			echo "找不到此用户ID, ".$memberid;
			exit;
		}
		$groups = getGroupList(-1, $groupid);
		if(empty($groups)){
			echo "找不到此队伍ID, ".$groupid;
			exit;
		}
		$matchs = getMatchList($groups[0]->match_id);
		if(empty($matchs)){
			echo "找不到此队伍的比赛ID, error code : ".$groups[0]->match_id;
			exit;
		}
		if($matchs[0]->stage != 1) {
			echo "比赛不处于报名阶段,无法退出 . error code : ".$groups[0]->match_id;
			exit;
		}
		if($groups[0]->captain_id == $user_ID || // 队长踢人
		 $memberid == $user_ID) {  // 队员离开
			updateUser($memberid, $matchid, 0, -1, -1, 0, -1, 0);
			echo "已退出队伍";
			exit;
		}
		echo "权限不足.";
		exit;
	case 'applygroup' :
		$users = getUserList($user_ID, $matchid);
		if(!empty($users)) {
			$groupid = $_REQUEST['groupid'];
			if(intval($users[0]->apply_group)) {
				echo "您已经申请了其他的队伍!";
				exit;
			}
			$groups = getGroupList($matchid, $groupid);
			if(empty($groups)){
				echo "比赛".$matchid."中找不到这个队伍!".$groupid;
				exit;
			}
			$groupusers = getUserList(-1, -1, $groupid);
			if(($groups[0]->maxpeople - 1) < count($groupusers)){
				echo "这个队伍中的人数已经满了!".$groupid;
				exit;
			}
			updateUser($user_ID, $matchid, $groupid, -1, -1, 1);
			echo "申请成功!";
			exit;
		}
		echo "你尚未参加此项比赛!";
		exit ;
	case 'passapplygroup' :
		$memberid = intval($_REQUEST['memberid']);
		$users = getUserList($memberid, $matchid);
		if(!empty($users)) {
			$groupid = intval($_REQUEST['groupid']);
			if($users[0]->group_id == $groupid) {
				updateUser($memberid, $matchid, $groupid, -1, -1, 1, -1, 1);
				echo "通过申请!";
				exit;
			}
			echo "申请失败!".$users[0]->group_id.":".$groupid;
			exit;
		}
		echo "此用户尚未参加此项比赛!";
		exit;
	case 'creategroup' :
		$users = getUserList($user_ID, $matchid);
		if(!intval($users[0]->apply_match)) {
			echo "你尚未参加此项比赛!";
			exit;
		}
		if(intval($users[0]->apply_group)) {
			echo "您已经申请了其他的队伍!";
			exit;
		}
		$groupname = trim($_REQUEST['groupname']);
		$success = addGroup($groupname, $user_ID, $matchid);
		if(intval($success)) {
			$groups = getGroupList($matchid, -1, $user_ID);
			updateUser($user_ID, $matchid, $groups[0]->id, -1, -1, 1, -1, 1);
			echo "申请成功!";
			exit;
		}
		echo "申请发生错误error code : ".$success;
		exit;
	case 'ranksubmit' :
		$matchId = intval($_POST['matchId']);
		$matchTypeId = intval($_POST['matchTypeId']);
		$scheduleId = intval($_POST['scheduleId']);
		$applyId = intval(addUserRankApply($user_ID, $matchId, $scheduleId));
		if(!$applyId) {
			echo "申请发生错误, Code:".$applyId;
			exit;
		}
		$submit = getUserRankApplyList(-1, $user_ID, $matchId, $scheduleId);
		$rankTypeList = getRankTypeList(-1, $matchTypeId);
		foreach ($rankTypeList as $rankType) {
			$value = intval($_POST['rank-'.$rankType->id]);
			if($value && $submit[0]->id) {
				$result = addUserRank($user_ID, $matchTypeId, $rankType->id, $value, 0, $submit[0]->id);
				if(!$result){
					echo "录入信息失败,Code:".$rankType->id;
					exit;
				}
			} else {
				echo "录入信息失败,Error Code:".$value." AND ".$submit[0]->id;
				exit;
			}
		}
		echo "提交选手成绩完成";
		exit;
	default :
		echo "无法解析此函数";
		exit ;
	}
}

?>