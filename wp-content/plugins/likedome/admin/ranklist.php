<?php
### Check Whether User Can Manage Likedome
if(!current_user_can('administrator')) {
    die('Access Denied');
}
### Variables Variables Variables
$base_name = plugin_basename('likedome/admin/ranklist.php');
$base_page = 'admin.php?page='.$base_name;
$category = trim($_REQUEST['category']);

define( 'LIKEDOME_PLUGINS_ROOT', dirname( dirname( __FILE__ ) ) );
require_once( LIKEDOME_PLUGINS_ROOT .  '/config.php' );
require_once( LIKEDOME_PLUGINS_ROOT . '/includes/classes.php');
require_once( LIKEDOME_PLUGINS_ROOT . '/includes/templatespart.php');

### Determines Which Category It Is
switch($category) {
    // Add
    case 'addRankType':
        $matchTypeId = intval($_POST['matchTypeId']);
        $rankName = trim($_POST['rankName']);
        $succe = addRankType($matchTypeId, $rankName);
        if(!intval($succe)) {
            echo "比分类型添加失败";
            return;
        }
        echo "比分类型添加成功";
        break;
    // Del
    case 'delRankType':
      	$currentRankTypeSelect = intval($_POST['currentRankTypeSelect']);
	    $succe = delRankType($currentRankTypeSelect);
	    if($succe != 1) {
           echo "删除比分类型失败";
           return;
	    }
	    echo "删除比分类型完成";
    break;
    // Update
	case 'updateRank':
	    $matchTypeId = intval($_POST['matchTypeId']);
	    $userId = intval($_POST['userId']);
	    $rankTypeList = getRankTypeList(-1, $matchTypeId);
	    foreach ($rankTypeList as $rankType) {
	    	addUserRank($userId, $matchTypeId, $rankType->id, intval($_POST['rank-'.$rankType->id]));
	    }
	    echo "提交选手成绩完成";
    break;
    // Main Page
    default:
    	$username = trim($_POST['username']);
     	if(!empty($username)) {
     		$user = get_user_by('login', $username);
     		$userid = $user->ID;
     	}
		$currentRankTypeSelect = intval($_POST['currentRankTypeSelect']);
		$currentType = intval($_POST['currentTypeSelect']);
		if($currentRankTypeSelect < 1)
			$currentRankTypeSelect = 1;
		if($currentType < 1)
			$currentType = 1;
		$userRankList = getUserRankList(-1, $currentType, -1, -1, 1);
		$tpl->SetVar('userRankList', $userRankList);
		$tpl->SetVar('currentRankTypeSelect', $currentRankTypeSelect);
		$tpl->SetVar('currentType', $currentType);
		$tpl->SetVar('rankTypeList', getRankTypeList(-1, $currentType));
        echo '<h2>'. '数据排行' . '</h2>';
        echo $tpl->GetTemplate('ranklist.php');
        break;
}
?>