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
function addMatch($name, $type=1, $stage = 1, $grouplimit=200, $groupmemberlimit=20, $groupnumber=0) {
    global $wpdb;
    if(!empty($name))
        $result = $wpdb->insert('wp_likedome_match_race', array( 'name' =>$name, 'type' => $type, 'stage' => $stage, 'grouplimit' => $grouplimit, 'groupmemberlimit' => $groupmemberlimit, 'groupnumber' => $groupnumber));
    return $result;
}

/**
 * 删除比赛
 */
function delMatch($id) {
    global $wpdb;
    $result = $wpdb->query("DELETE FROM wp_likedome_match_race WHERE id =".$id);
    return $result;
}

/**
 * 删除用户
 */
function delUser($uid, $matchId) {
	global $wpdb;
	$result = $wpdb->query("DELETE FROM wp_likedome_match_user WHERE uid=".$uid." AND match_id=".$matchId);
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
    $result = $wpdb->update('wp_likedome_match_race', $columns, array( 'id' => $_matchid));
    return $result;
}

/**
 * 获取比赛分类列表, stage = 比赛阶段, 0未开始, 1报名中, 2进行中, 3已结束
 */
function getMatchList($id = -1, $type = -1, $stage = -1, $limit = 10, $begin = 0) {
    global $wpdb;
    $sql = 'SELECT id, name, stage, type, grouplimit, groupmemberlimit, groupnumber FROM wp_likedome_match_race';
    $columns = array();
    if($id > -1)
        array_push($columns, 'id='.$id);
    if($stage > 0)
        array_push($columns, 'stage='.$stage);
    if($type > 0)
        array_push($columns, 'type='.$type);
    if(count($columns) > 0)
        $sql.= ' WHERE ' . implode( ' AND ', $columns );
    $result = $wpdb->get_results($sql.' ORDER BY id DESC LIMIT '.$begin.', '.$limit);
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
 * 查询此ID认证资料
 */
function getUserProfile($userid) {
	global $wpdb;
	$_userid = intval($userid);
	$sql = "SELECT uid, realname, gender,birthyear, birthmonth,birthday,constellation, zodiac, telephone, mobile, idcardtype, idcard, address, zipcode, nationality, birthprovince, birthcity, birthdist, birthcommunity, resideprovince, residecity, residedist, residecommunity, residesuite, graduateschool, company, education, occupation, position, revenue, affectivestatus, lookingfor, bloodtype, height, weight, alipay, icq, qq, yahoo, msn, taobao, site, bio, interest, field1, field2, field3, field4, field5, field6, field7, field8 FROM pre_common_member_profile WHERE uid =".$_userid;
	$verify = $wpdb->get_results($sql);
	return $verify;
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
function getGroupList($matchid = 0, $groupid = 0, $userid = 0, $limit = 10, $begin = 0) {
	global $wpdb;
	$sql = 'SELECT id, match_id, name, captain_id, maxpeople, timestamp, state FROM wp_likedome_match_group';
	$columns = array();
	if($userid > 0)
		array_push($columns, 'captain_id='.$userid);
	if($groupid > 0)
		array_push($columns, 'id='.$groupid);
	if($matchid > 0)
		array_push($columns, 'match_id='.$matchid);
	if(count($columns) > 0)
		$sql.= ' WHERE ' . implode( ' AND ', $columns );
	$result = $wpdb->get_results($sql.' LIMIT '.$begin.', '.$limit);
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
 * 获取人员列表
 */
function getUserList($userId = -1, $matchId = -1, $groupId = -1, $apply_follow = -1, $apply_match = -1, $apply_group = -1, $pass_apply_match = -1, $pass_apply_group = -1, $limit = 10, $begin = 0) {
    global $wpdb;
    $_userId = intval($userId);
    $_matchId = intval($matchId);
    $_groupId = intval($groupId);
    $_apply_follow = intval($apply_follow);
    $_apply_match = intval($apply_match);
    $_apply_group = intval($apply_group);
    $_pass_apply_match = intval($pass_apply_match);
    $_pass_apply_group = intval($pass_apply_group);
    $sql = 'SELECT uid, match_id, group_id, apply_match, apply_group, apply_follow, pass_apply_match, pass_apply_group FROM wp_likedome_match_user';
	if($_userId != 0) {
	    $columns = array();
	    if($_userId > -1)
	    	array_push($columns, 'uid='.$_userId);
	    if($_matchId > -1)
	    	array_push($columns, 'match_id='.$_matchId);
	    if($_groupId > -1)
	    	array_push($columns, 'group_id='.$_groupId);
	    if($_apply_follow > -1)
	    	array_push($columns, 'apply_follow='.$_apply_follow);
	    if($_apply_match > -1)
	    	array_push($columns, 'apply_match='.$_apply_match);
	    if($_apply_group > -1)
	    	array_push($columns, 'apply_group='.$_apply_group);
	    if($_pass_apply_match > -1)
	    	array_push($columns, 'pass_apply_match='.$_pass_apply_match);
	    if($_pass_apply_group > -1)
	    	array_push($columns, 'pass_apply_group='.$_pass_apply_group);
	    if(count($columns) > 0)
	    	$sql.= ' WHERE ' . implode( ' AND ', $columns );
	}
    $result = $wpdb->get_results($sql.' LIMIT '.$begin.', '.$limit);
    return $result;
}

/**
 * 设置人员属性
 */
function updateUser($userId, $matchId, $groupId = -1, $apply_follow = -1, $apply_match = -1, $apply_group = -1, $pass_apply_match = -1, $pass_apply_group = -1) {
	global $wpdb;
	$_userId = intval($userId);
	$_matchId = intval($matchId);
	$_groupId = intval($groupId);
	$_apply_follow = intval($apply_follow);
	$_apply_match = intval($apply_match);
	$_apply_group = intval($apply_group);
	$_pass_apply_match = intval($pass_apply_match);
	$_pass_apply_group = intval($pass_apply_group);
	$columns = array();
	if($_groupId > -1)
		$columns['group_id'] = intval($_groupId);
	if($_apply_follow > -1)
		$columns['apply_follow'] = intval($_apply_follow);
	if($_apply_match > -1)
		$columns['apply_match'] = intval($_apply_match);
	if($_apply_group  > -1)
		$columns['apply_group'] = intval($_apply_group);
	if($_pass_apply_match  > -1)
		$columns['pass_apply_match'] = intval($_pass_apply_match);
	if($_pass_apply_group  > -1)
		$columns['pass_apply_group'] = intval($_pass_apply_group);
	if(($_userId > 0) && ($_matchId > 0)) {
		$users = getUserList($userId, $matchId);
		if(empty($users))
			return $wpdb->insert('wp_likedome_match_user', array( 'uid' => $_userId, 'match_id' => $_matchId) + $columns);
		$result = $wpdb->update('wp_likedome_match_user', $columns, array( 'uid' => $_userId, 'match_id' => $_matchId));
	}
	return $result;
}

// 用户名 真实姓名  性别 手机 证件类型 证件号 QQ
?>