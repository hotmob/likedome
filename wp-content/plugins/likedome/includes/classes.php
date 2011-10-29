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
 * 添加比赛分类
 */
function addMatchType($matchtype) {
    global $wpdb;
    if(!empty($matchtype))
        $result = $wpdb->insert('wp_likedome_match_type', array( 'type' => $matchtype ));
    return $result;
}

/**
 * 获取比赛分类列表
 */
function getMatchTypeList() {
    global $wpdb;
    $result = $wpdb->get_results('SELECT id, type FROM wp_likedome_match_type', OBJECT_K );
    return $result;
}

/**
 * 添加比赛
 */
function addMatch($name, $type=1 , $stage = 1, $grouplimit=200, $groupmemberlimit=20, $groupnumber=0) {
    global $wpdb;
    if(!empty($name))
        $result = $wpdb->insert('wp_likedome_match', array( 'name' =>$name, 'type' => $type, 'stage' => $stage, 'grouplimit' => $grouplimit, 'groupmemberlimit' => $groupmemberlimit, 'groupnumber' => $groupnumber));
    return $result;
}

/**
 * 删除比赛
 */
function delMatch($id) {
    global $wpdb;
    $result = $wpdb->query("DELETE FROM wp_likedome_match WHERE id =".$id);
    return $result;
}

/**
 * 修改比赛
 */
function updateMatch($matchid, $type = -1, $stage = -1, $groupnumber = -1, $grouplimit = -1, $groupmemberlimit = -1) {
    global $wpdb;
    $columns = array();
    $_matchid = intval($matchid);
    if($type != -1)
        $columns['type'] = intval($type);
    if($stage != -1)
        $columns['stage'] = intval($stage);
    if($grouplimit != -1)
        $columns['grouplimit'] = intval($grouplimit);
    if($groupmemberlimit != -1)
        $columns['groupmemberlimit'] = intval($groupmemberlimit);
    if($groupnumber != -1)
        $columns['groupnumber'] = intval($groupnumber);
    $result = $wpdb->update('wp_likedome_match', $columns, array( 'id' => $_matchid));
    return $result;
}

/**
 * 获取比赛分类列表, stage = 比赛阶段, 0未开始, 1报名中, 2进行中, 3已结束
 */
function getMatchList($id = 0, $type = 0, $stage = 0, $limit = 10, $begin = 0) {
    global $wpdb;
    $sql = 'SELECT id, name, stage, type, grouplimit, groupmemberlimit, groupnumber FROM wp_likedome_match';
    $columns = array();
    if($id > 0)
        array_push($columns, 'id='.$id);
    if($stage > 0)
        array_push($columns, 'stage='.$stage);
    if($type > 0)
        array_push($columns, 'type='.$type);
    if(count($columns) > 0)
        $sql.= ' WHERE ' . implode( ' AND ', $columns );
    $result = $wpdb->get_results($sql.' LIMIT '.$begin.', '.$limit);
    return $result;
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
 * 和比赛相关联的文章列表
 */
function getMatchPostList($matchid) {
	global $wpdb;
	$_matchid = intval($matchid);
	$result = $wpdb->get_results('SELECT post_id FROM wp_postmeta WHERE meta_key = "链接比赛" AND meta_value = '.$_matchid);
	return $result;
} 

/**
 * 参加比赛队伍列表
 */
function getMatchGroupList($matchid = 0) {
	global $wpdb;
    $matchid = intval($matchid);
    if($matchid > 0)
	   $where = ' WHERE match_id='.$matchid;
	$result = $wpdb->get_results('SELECT id, match_id, name, captain_id, maxpeople, timestamp, state FROM wp_likedome_match_group'.$where);
	return $result;
}

/**
 * 查询选手参加比赛列表
 */
function getUserApplyList($userid) {
	global $wpdb;
	$_userid = intval($userid);
	$result = $wpdb->get_results('SELECT apply, match_id FROM wp_likedome_match_apply WHERE uid = '.$_userid);
	return $result;
} 

/**
 * 查询选手关注比赛列表
 */
function getUserFollowList($userid) {
	global $wpdb;
	$_userid = intval($userid);
	$result = $wpdb->get_results('SELECT uid, match_id FROM wp_likedome_match_follow WHERE uid = '.$_userid);
	return $result;
}

/**
 * 创建队伍
 */
function addGroup($name, $captain_id, $matchId) {
    global $wpdb;
    $_matchId = intval($matchId);
    if(!empty($name)) {
        $_captain_id = intval($captain_id);
        $matchs = getMatchList($_matchId);
        if(count($matchs) > 0) {
            $update = updateMatch($_matchId, -1, -1, (intval($matchs[0]->groupnumber) + 1));
            if($update > 0)
                $result = $wpdb->insert('wp_likedome_match_group', array( 'captain_id' => $_captain_id, 'name' => $name, 'match_id' => $_matchId, 'maxpeople' => $matchs[0]->groupmemberlimit ));
            return $result;
        }
    }
    return null;
}

/**
 * 申请加入队伍
 */
function setUserGroup($userid, $groupid) {
	global $wpdb;
	$user_id = intval($userid);
	$group_id = intval($groupid);
	$result = $wpdb->insert('wp_likedome_match_group_user', array( 'user_id' => $_userid, 'group_id' => $group_id ));
	return $result;
}

/**
 * 获取用户队伍申请
 */
function getUserGroup($userid, $groupid) {
	global $wpdb;
	$user_id = intval($userid);
	$group_id = intval($groupid);
	$result = $wpdb->get_var("SELECT state FROM wp_likedome_match_group_user WHERE user_id = $user_id AND group_id = $group_id");
	return $result;
} 

/**
 * 参加比赛队伍人员列表
 */
function getGroupUserList($groupid) {
    global $wpdb;
    $group_id = intval($groupid);
    $result = $wpdb->get_results('SELECT user_id FROM wp_likedome_match_group_user WHERE state=1 AND group_id = '.$group_id);
    return $result;
}
?>