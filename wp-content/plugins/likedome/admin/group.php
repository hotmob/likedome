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
require_once( LIKEDOME_PLUGINS_ROOT . '/config.php' );
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
	  $groupid = intval($_POST['groupid']);
	  $matchid = intval($_POST['matchid']);
      $succe = delGroup($groupid);
      if($succe != 1) {
		  echo "删除队伍:".$groupid."失败";
          return;
      }
	  updateMatch($matchid, -1, -1, count(getGroupList($matchid)));
      echo "成功删除队伍:".$groupid;
      break;
    // Update
    case 'update':
      break;
    // Schedule
    case 'schedule':
		$rid = intval($_GET['rid']);
		$matchId = intval($_GET['matchId']);
        $groupList = getGroupList($matchId);
		if(empty($groupList) || !intval($groupList)) {
			echo "找不到比赛ID或没有比赛队伍!";
			return;
		} else if (count($groupList)%2){
			echo '<h2>'.'对阵图设置'.'</h2>';
			echo "现在的队伍数量是".count($groupList).", 对战类型为 one Vs one, 因此无法生成对阵图, 请删除一个队伍后再试;";
			return;
		}
		$scheduleList = getScheduleList($matchId, $rid);
		$tpl->SetVar('scheduleList', $scheduleList);
		$tpl->SetVar('rid', $rid);
        $tpl->SetVar('groups', $groupList);
        $tpl->SetVar('paging', count($groupList)/20);
		$tpl->SetVar('matchId', $matchId);
    	echo '<h2>'.'对阵图设置'.'</h2>';
    	echo $tpl->GetTemplate('matchschedule.php');
      	break;
	case 'addschedule':
		$ngid = intval($_REQUEST['ngid']);
		$sgid = intval($_REQUEST['sgid']);
		$round = trim($_REQUEST['round']);
		$begin = trim($_REQUEST['begin']);
		$end = trim($_REQUEST['end']);
		$result = trim($_REQUEST['result']);
		$rid = intval($_REQUEST['rid']);
		$matchId = intval($_REQUEST['matchid']);
		$succe = addSchedule($ngid, $sgid, $matchId, $rid, $round, $begin, $end, $result);
        if($succe != 1) {
            echo "添加队伍对阵图失败";
            return;
        }
        echo "添加队伍对阵图成功";
		break; 
	// Del Schedule
    case 'delschedule':
	  $id = intval($_REQUEST['id']);
      $succe = delSchedule($id);
      if($succe != 1) {
		  echo "删除队伍对阵图:".ngid."失败";
          return;
      }
	  updateMatch($matchid, -1, -1, count(getGroupList($matchid)));
      echo "成功删除队伍对阵图:".$groupid;
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

