<?php
### Check Whether User Can Manage Likedome
if(!current_user_can('administrator')) {
    die('Access Denied');
}
### Variables Variables Variables
$base_name = plugin_basename('likedome/admin/group.php');
$base_page = 'admin.php?page='.$base_name;
$category = trim($_REQUEST['category']);

define( 'LIKEDOME_PLUGINS_ROOT', dirname( dirname( __FILE__ ) ) );
require_once( LIKEDOME_PLUGINS_ROOT .  '/config.php' );
require_once( LIKEDOME_PLUGINS_ROOT . '/includes/classes.php');
require_once( LIKEDOME_PLUGINS_ROOT . '/includes/templatespart.php');

### Determines Which Category It Is
switch($category) {
    // Add
    case 'add':
        $name = trim($_POST['groupname']);
        $matchId = intval($_POST['matchId']);
        $succe = addGroup($name, 0, $matchId);
        if($succe != 1) {
            echo "添加队伍提交失败";
            return;
        }
        echo "添加队伍提交成功";
        break;
    // Del
    case 'del':
      break;
    // Update
    case 'update':
      break;
    // Schedule
    case 'schedule':
		$round = intval($_REQUEST['round']);
		$matchId = intval($_GET['matchId']);
        $groupList = getGroupList($matchId);
		if(empty($groupList)) {
			echo "找不到比赛ID";
			return;
		}
		$optionString = getGroupListSelect($matchId);
        $tpl->SetVar('groups', $groupList);
        $tpl->SetVar('paging', count($groupList)/20);
		$tpl->SetVar('matchId', $matchId);
		$tpl->SetVar('round', $round);
		$tpl->SetVar('optionString', $optionString);
    	echo '<h2>'.'对阵图设置'.'</h2>';
    	echo $tpl->GetTemplate('matchschedule.php');
      	break;
     // Main Page
    default:
        $matchId = 0;
        $matchId = intval($_GET['matchId']);
        $groupList = getGroupList($matchId);
        if($matchId != 0) {
            $matchs = getMatchList($matchId);
            $tpl->SetVar('match', $matchs[0]);
        }
        $tpl->SetVar('groups', $groupList);
        $tpl->SetVar('paging', count($groupList)/20);
        echo '<h2>'. '队伍列表' . '</h2>';
        echo $tpl->GetTemplate('grouplist.php');
        break;
}
?>

