<?php
### pre_common_member_verify
### e.g. wp-content/plugins/likedome/tournament.php?opt=['methodname']&matchid=1&flag=1
define( 'WP_ROOT', join( DIRECTORY_SEPARATOR, array_slice( explode( DIRECTORY_SEPARATOR, dirname( __FILE__ ) ), 0, -4 ) ) );

require_once( WP_ROOT . '/wp-load.php' );
include_once( WP_ROOT . '/wp-config.php');
include_once( WP_ROOT . '/wp-includes/wp-db.php');

/**
 * 查询页面编码
 */
function getCharset() {
	return get_option('blog_charset');
}

/**
 * 查询此ID是否经过选手认证
 */
function getUserVerify($userid) {
	global $wpdb;
	$_userid = intval($userid);
	$verify = $wpdb->get_var("SELECT verify1 FROM pre_common_member_verify WHERE uid = $_userid");
	return $verify;
} 

/**
 * 查询选手是否已经报名, 已经报名返回审核状态值, 否则返回null
 */
function getUserApply($userid, $matchid) {
	global $wpdb;
	$_userid = intval($userid);
	$_matchid = intval($matchid);
	$result = $wpdb->get_var("SELECT apply FROM wp_likedome_match_apply WHERE uid = $_userid AND match_id = $_matchid");
	return $result;
}

/**
 * 查询用户是否已经关注比赛
 */
function getUserFollow($userid, $matchid) {
	global $wpdb;
	$_userid = intval($userid);
	$_matchid = intval($matchid);
	$result = $wpdb->get_var("SELECT uid FROM wp_likedome_match_follow WHERE uid = $_userid AND match_id = $_matchid");
	return $result;
}

/**
 * 选手报名
 */
function setUserApply($userid, $matchid) {
	global $wpdb;
	$_userid = intval($userid);
	$_matchid = intval($matchid);
	$result = $wpdb->insert('wp_likedome_match_apply', array( 'uid' => $_userid, 'match_id' => $_matchid ));
	return $result;
}

/**
 * 关注比赛
 */
function setUserFollow($userid, $matchid) {
	global $wpdb;
	$_userid = intval($userid);
	$_matchid = intval($matchid);
	$result = $wpdb->insert('wp_likedome_match_follow', array( 'uid' => $_userid, 'match_id' => $_matchid ));
	return $result;
} 

/**
 * 参加比赛人员列表
 */
function getMatchApplyList($matchid) {
	global $wpdb;
	$_matchid = intval($matchid);
	$result = $wpdb->get_results('SELECT uid FROM wp_likedome_match_apply WHERE match_id = '.$_matchid, ARRAY_N);
	return $result;
} 

/**
 * 关注比赛人员列表
 */
function getMatchFollowList($matchid) {
	global $wpdb;
	$_matchid = intval($matchid);
	$result = $wpdb->get_results('SELECT uid FROM wp_likedome_match_follow WHERE match_id = '.$_matchid, ARRAY_N);
	return $result;
} 

/**
 * 参加比赛人员数量
 */
function getMatchApplyNum($matchid) {
	$result = getMatchApplyList($matchid);
	if(is_array($result))
		return count($result);
	return 0;
} 

/**
 * 关注比赛人员数量
 */
function getMatchFollowNum($matchid) {
	$result = getMatchFollowList($matchid);
	if(is_array($result))
		return count($result);
	return 0;
} 

/**
 * 查询选手参加比赛列表
 */
function getUserApplyList($userid) {
	global $wpdb;
	$_userid = intval($userid);
	$result = $wpdb->get_results('SELECT apply, match_id FROM wp_likedome_match_apply WHERE uid = '.$_userid, ARRAY_A);
	return $result;
} 

/**
 * 查询选手关注比赛列表
 */
function getUserFollowList($userid) {
	global $wpdb;
	$_userid = intval($userid);
	$result = $wpdb->get_results('SELECT uid, match_id FROM wp_likedome_match_follow WHERE uid = '.$_userid, ARRAY_A);
	return $result;
} 
?>