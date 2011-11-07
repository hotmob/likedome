<?php
### Check Whether User Can Manage Likedome
if(!current_user_can('administrator')) {
    die('Access Denied');
}
### Variables Variables Variables
$base_name = plugin_basename('likedome/admin/audit.php');
$base_page = 'admin.php?page='.$base_name;
$category = trim($_REQUEST['category']);

define( 'LIKEDOME_PLUGINS_ROOT', dirname( dirname( __FILE__ ) ) );
require_once( LIKEDOME_PLUGINS_ROOT . '/config.php' );
require_once( LIKEDOME_PLUGINS_ROOT . '/includes/classes.php');
require_once( LIKEDOME_PLUGINS_ROOT . '/includes/templatespart.php');

### Determines Which Category It Is
switch($category) {
    // Add
    case 'joingroup':
        $groupId = intval($_POST['groupId']);
        $matchId = intval($_POST['matchId']);
        $userId = intval($_POST['memberId']);
        $succe = updateUser($userId, $matchId, $groupId, -1, 1, 1, 1, 1);
        if($succe != 1) {
            echo "添加队伍提交失败";
            return;
        }
        echo "添加队伍提交成功";
        break;
    // Del
    case 'del':
      	$matchId = intval($_POST['matchId']);
      	$userId = intval($_POST['userId']);
	    $succe = delUser($userId, $matchId);
	    if($succe != 1) {
           echo "删除选手失败";
           return;
	    }
	    echo "删除选手完成";
      break;
    // Update
    case 'update':
      $matchTypeId = intval($_POST['matchTypeId']);
      $submitId = intval($_POST['submitId']);
      $userId = intval($_POST['userId']);
      $rankTypeList = getUserRankList($userId, $matchTypeId, -1, -1, 0, $submitId);
      $sumRankTypeList = getUserRankList($userId, $matchTypeId, -1, -1, 1, 0, OBJECT_K);
      foreach ($rankTypeList as $rankType) {
      	if(!empty($sumRankTypeList) && intval($sumRankTypeList)) { // update
      		$sum = $sumRankTypeList[$rankType->uid]->value + $rankType->value;
      		$result = updateUserRank($sumRankTypeList[$rankType->uid]->uid, $sumRankTypeList[$rankType->uid]->matchTypeId, $sumRankTypeList[$rankType->uid]->rid, $sum, 1);
      		if($result){
      			delUserRank($rankType->submitId);
      		} else {
      			echo "提交积分 rankType:".$rankType->submitId." 时出错,".$sumRankTypeList[$rankType->uid]->uid." : ".$sumRankTypeList[$rankType->uid]->matchTypeId." : ".$sumRankTypeList[$rankType->uid]->rid;
      			print_r($sumRankTypeList);
      			exit;
      		}
      	} else {
    		$result = updateUserRank($userId, $matchTypeId, $rankType->rid, -1, 1, 0);
    		if(!$result){
    			echo "新建积分 rankType:".$rankType->rid." 时出错";
    			exit;
    		}
      	}
      }
      updateUserRankApply($submitId, 1);
      echo "提交选手成绩完成";
      break;
    // Main Page
    default:
    	$username = trim($_POST['username']);
    	if(!empty($username)) {
    		$user = get_user_by('login', $username);
    		$userid = $user->ID;
    	}
		$currentType = intval($_POST['currentTypeSelect']);
		if($currentType < 1)
			$currentType = 1;
		$userRankList = getUserRankList(-1, $currentType, -1, -1, 0);
		$tpl->SetVar('userRankList', $userRankList);
		$tpl->SetVar('currentType', $currentType);
		$tpl->SetVar('rankTypeList', getRankTypeList(-1, $currentType));
        echo '<h2>'. '数据审核' . '</h2>';
        echo $tpl->GetTemplate('audit.php');
        break;
}
?>