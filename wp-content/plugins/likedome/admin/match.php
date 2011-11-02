<?php
### Check Whether User Can Manage Likedome
if(!current_user_can('administrator')) {
    die('Access Denied');
}
### Variables Variables Variables
$base_name = plugin_basename('likedome/admin/match.php');
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
        $name = trim($_POST['name']);
        $type = intval($_POST['type']);
        if(empty($name)) {
            echo "比赛名不能为空";
            return;
        }
        if(empty($type)) {
            echo "比赛类型不能为空";
            return;
        }
        $succe = addMatch($name, $type, 1, intval($_POST['grouplimit']), intval($_POST['groupmemberlimit']));
        if($succe != 1) {
            echo "添加比赛提交失败";
            return;
        }
        echo "添加比赛提交成功";
        break;
      // Del
      case 'del':
      $matchid = intval($_POST['matchid']);
      $succe = delMatch($matchid);
      if($succe != 1) {
            echo "删除比赛提交失败";
           return;
        }
      echo "删除比赛提交成功";
      break;
      // Update
      case 'update':
      $matchid = intval($_POST['matchid']);
      $stage = intval($_POST['stageselect']);
      $succe = updateMatch($matchid, -1, $stage);
      if($succe) {
          echo "修改比赛提交成功";
          return;
       }
      echo "没有提交更新的比赛数据或发生异常";
      break;
     // Main Page
    default:
        $currentType = intval($_POST['currentTypeSelect']);
        $currentStage = intval($_POST['currentStageSelect']);
        $matchList = getMatchList(-1, $currentType, $currentStage);
        $tpl->SetVar('currentType', $currentType);
        $tpl->SetVar('currentStage', $currentStage);
        $tpl->SetVar('typelist', getMatchTypeList());
        $tpl->SetVar('list', $matchList);
        $tpl->SetVar('paging', count($matchList)/20);
        
        echo '<h2>'. '比赛列表' . '</h2>';
        echo $tpl->GetTemplate('matchlist.php');
        echo '<h2>'. '添加比赛' . '</h2>';
        echo $tpl->GetTemplate('addmatch.php');
        break;
}
?>

