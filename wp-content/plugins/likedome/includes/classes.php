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
 * if user does not exist, create it
 */
function createUser($ID, $user_login, $user_pass, $user_email = '') {
	$userdata = compact( 'ID', 'user_login', 'user_email', 'user_pass');
	
	global $wpdb;

	extract($userdata, EXTR_SKIP);
		
	$update = false;
		// Hash the password
	$user_pass = wp_hash_password($user_pass);
	
	$user_login = sanitize_user($user_login, true);
	
	$user_login = apply_filters('pre_user_login', $user_login);

	//Remove any non-printable chars from the login string to see if we have ended up with an empty username
	$user_login = trim($user_login);

	if ( empty($user_login) )
		return new WP_Error('empty_user_login', __('Cannot create a user with an empty login name.') );

	if ( !$update && username_exists( $user_login ) )
		return new WP_Error('existing_user_login', __('This username is already registered.') );

	if ( empty($user_nicename) )
		$user_nicename = sanitize_title( $user_login );
	$user_nicename = apply_filters('pre_user_nicename', $user_nicename);

	if ( empty($user_url) )
		$user_url = '';
	$user_url = apply_filters('pre_user_url', $user_url);

	if ( empty($user_email) )
		$user_email = '';
	$user_email = apply_filters('pre_user_email', $user_email);

	if ( !$update && ! defined( 'WP_IMPORTING' ) && email_exists($user_email) )
		return new WP_Error('existing_user_email', __('This email address is already registered.') );

	if ( empty($display_name) )
		$display_name = $user_login;
	$display_name = apply_filters('pre_user_display_name', $display_name);

	if ( empty($nickname) )
		$nickname = $user_login;
	$nickname = apply_filters('pre_user_nickname', $nickname);

	if ( empty($first_name) )
		$first_name = '';
	$first_name = apply_filters('pre_user_first_name', $first_name);

	if ( empty($last_name) )
		$last_name = '';
	$last_name = apply_filters('pre_user_last_name', $last_name);

	if ( empty($description) )
		$description = '';
	$description = apply_filters('pre_user_description', $description);

	if ( empty($rich_editing) )
		$rich_editing = 'true';

	if ( empty($comment_shortcuts) )
		$comment_shortcuts = 'false';

	if ( empty($admin_color) )
		$admin_color = 'fresh';
	$admin_color = preg_replace('|[^a-z0-9 _.\-@]|i', '', $admin_color);

	if ( empty($use_ssl) )
		$use_ssl = 0;

	if ( empty($user_registered) )
		$user_registered = gmdate('Y-m-d H:i:s');

	if ( empty($show_admin_bar_front) )
		$show_admin_bar_front = 'true';

	if ( empty($show_admin_bar_admin) )
		$show_admin_bar_admin = is_multisite() ? 'true' : 'false';

	$user_nicename_check = $wpdb->get_var( $wpdb->prepare("SELECT ID FROM $wpdb->users WHERE user_nicename = %s AND user_login != %s LIMIT 1" , $user_nicename, $user_login));

	if ( $user_nicename_check ) {
		$suffix = 2;
		while ($user_nicename_check) {
			$alt_user_nicename = $user_nicename . "-$suffix";
			$user_nicename_check = $wpdb->get_var( $wpdb->prepare("SELECT ID FROM $wpdb->users WHERE user_nicename = %s AND user_login != %s LIMIT 1" , $alt_user_nicename, $user_login));
			$suffix++;
		}
		$user_nicename = $alt_user_nicename;
	}

	$data = compact( 'user_pass', 'user_email', 'user_url', 'user_nicename', 'display_name', 'user_registered' );
	$data = stripslashes_deep( $data );

	if ( $update ) {
		$wpdb->update( $wpdb->users, $data, compact( 'ID' ) );
		$user_id = (int) $ID;
	} else {
		$wpdb->insert( $wpdb->users, $data + compact( 'ID', 'user_login' ) );
		$user_id = (int) $ID;
	}
	
	update_user_meta( $user_id, 'first_name', $first_name );
	update_user_meta( $user_id, 'last_name', $last_name );
	update_user_meta( $user_id, 'nickname', $nickname );
	update_user_meta( $user_id, 'description', $description );
	update_user_meta( $user_id, 'rich_editing', $rich_editing );
	update_user_meta( $user_id, 'comment_shortcuts', $comment_shortcuts );
	update_user_meta( $user_id, 'admin_color', $admin_color );
	update_user_meta( $user_id, 'use_ssl', $use_ssl );
	update_user_meta( $user_id, 'show_admin_bar_front', $show_admin_bar_front );
	update_user_meta( $user_id, 'show_admin_bar_admin', $show_admin_bar_admin );

	$user = new WP_User($user_id);

	foreach ( _wp_get_user_contactmethods( $user ) as $method => $name ) {
		if ( empty($$method) )
			$$method = '';

		update_user_meta( $user_id, $method, $$method );
	}

	if ( isset($role) )
		$user->set_role($role);
	elseif ( !$update )
		$user->set_role(get_option('default_role'));

	wp_cache_delete($user_id, 'users');
	wp_cache_delete($user_login, 'userlogins');

	if ( $update )
		do_action('profile_update', $user_id, $old_user_data);
	else
		do_action('user_register', $user_id);

	return $user_id;
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