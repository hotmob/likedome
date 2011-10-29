<?php

### Check Whether User Can Manage Polls
if(!current_user_can('manage_likedome')) {
	die('Access Denied');
}

### Variables Variables Variables
$base_name = plugin_basename('likedome/admin/manager.php');
$base_page = 'admin.php?page='.$base_name;
$mode = trim($_GET['mode']);
$poll_id = intval($_GET['id']);
$poll_aid = intval($_GET['aid']);

### Form Processing 
if(!empty($_POST['do'])) {

}
echo "哈哈";
?>