<?php
### Check Whether User Can Manage Likedome
if(!current_user_can('administrator')) {
    die('Access Denied');
}
### Variables Variables Variables
$base_name = plugin_basename('likedome/admin/matchtype.php');
$base_page = 'admin.php?page='.$base_name;
$category = trim($_REQUEST['category']);

define( 'LIKEDOME_PLUGINS_ROOT', dirname( dirname( __FILE__ ) ) );
require_once( LIKEDOME_PLUGINS_ROOT .  '/config.php' );
require_once( LIKEDOME_PLUGINS_ROOT . '/includes/classes.php');
require_once( LIKEDOME_PLUGINS_ROOT . '/includes/templatespart.php');

### Determines Which Category It Is
switch($category) {
    // Add
    case 'add';
        $matchtype = trim($_POST['matchtype']);
        $succe = addMatchType($matchtype);
        if($succe != 1)
            echo "提交失败";
        echo "提交成功";
    break;
     // Main Page
    default:
        echo '<h2>'. '添加比赛类型' . '</h2>';
        echo $tpl->GetTemplate('addmatchtype.php');
    break;
}
?>

