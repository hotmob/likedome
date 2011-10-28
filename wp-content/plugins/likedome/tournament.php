<?php
### pre_common_member_verify
### e.g. wp-content/plugins/likedome/tournament.php?opt=['methodname']&type=1&flag=1
define( 'LIKEDOME_PLUGINS_ROOT', dirname( __FILE__ ) );

require_once(LIKEDOME_PLUGINS_ROOT.'/includes/classes.php');

tournament();
function tournament () {
	global $wpdb, $user_identity, $user_ID;
	header('Content-Type: text/html; charset='.getCharset().'');
	if(empty($_REQUEST['matchid']) || empty($_REQUEST['opt'])) {
		echo "参数错误!";
		exit ;
	}
	$matchid = intval($_REQUEST['matchid']);
	switch($_REQUEST['opt']) {
	case 'apply' :
		if (!empty($user_identity)) {
			$username = htmlspecialchars(addslashes($user_identity));
		} else if(!empty($_COOKIE['comment_author_'.COOKIEHASH])) {
			$username = htmlspecialchars(addslashes($_COOKIE['comment_author_'.COOKIEHASH]));
		} else {
			echo "需要登陆才可以报名";
			exit ;
		}
		if(!getUserVerify($user_ID)) {
			echo "需要选手认证才可以报名";
			exit;
		}
		$apply = $wpdb->query("SELECT verify1 FROM pre_common_member_verify WHERE uid = $user_ID");
		if(getUserApply($user_ID, $matchid) != NULL) {
			echo "你已经报过名了";
			exit;
		}
		setUserApply($user_ID, $matchid);
		if(getUserApply($user_ID, $matchid) != NULL) {
			echo "报名成功!";
			exit;
		}
		echo "报名时发生错误";
		exit;
	case 'follow' :
		setUserFollow($user_ID, $matchid);
		if(getUserFollow($user_ID, $matchid) != NULL) {
			echo "关注成功!";
			exit;
		}
		echo "关注时发生错误";
		exit ;
	case 'applygroup' :
		if(getUserApply($user_ID, $matchid) != NULL) {
			$groupid = $_REQUEST['groupid'];
			if(getUserGroup($user_ID, $groupid) != null) {
				echo "您已经申请了其他的队伍!";
				exit;
			}
			setUserGroup($user_ID, $groupid);
			echo "申请成功!";
			exit;
		}
		echo "你尚未参加此项比赛!";
		exit ;
	default :
		echo "无法解析此函数";
		exit ;
	}
}

?>