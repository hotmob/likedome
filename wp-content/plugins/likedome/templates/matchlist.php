<?php   global $tpl;  $matchtypelist = $tpl->getVar('typelist'); $matchlist = $tpl->getVar('list'); ?>
<table width="100%" border="0" cellspacing="1" cellpadding="0">
    <tr>
        <td width="5%"><label>
            <form name= "currentSelect" method= "post">
                <select name="currentTypeSelect" id="currentTypeSelect" onChange="document.currentSelect.submit();" >
                    <option value="0">全部比赛</option>
                    <?php 
                        foreach($matchtypelist as $matchtype){
                            echo '<option  value="'.$matchtype->id.'"';
                            if($tpl->getVar('currentType') == $matchtype->id) {
                                echo 'selected="selected"';
                            }
                            echo '>'.$matchtype->type.'</option>';
                    }  ?>
                </select></label></td>
        <td width="45%"><label>
                <select name="currentStageSelect" id="currentStageSelect" onChange= "document.currentSelect.submit();" >
                    <option value='1' <?php if($tpl->getVar('currentStage') == 1)  echo 'selected="selected"'; ?> >报名中</option>
                    <option value='2' <?php if($tpl->getVar('currentStage') == 2)  echo 'selected="selected"'; ?> >进行中</option>
                    <option value='3' <?php if($tpl->getVar('currentStage') == 3)  echo 'selected="selected"'; ?> >已结束</option>
                </select></label>
            </form>
        </td>
        <td width="10%" colspan="5"></td>
    </tr>
</table><table class="widefat" style="line-height:30px;">
    <thead>
        <tr>
            <th width="10%">ID</th>
            <th width="20%">比赛名称</th>
            <th width="10%">比赛分类</th>
            <th width="10%">状态</th>
            <th width="10%">队伍上限</th>
            <th width="10%">队员上限</th>
            <th width="10%">队伍数量</th>
            <th width="10%">编辑比赛</th>
            <th width="10%">删除比赛</th>
        </tr>
    </thead>
    <?php foreach($matchlist as $match) : ?>
        
        <tr id="poll-5" class="highlight">
            <form method="post">
            <td><strong><?php echo $match->id; ?></strong></td>
            <td><strong><a href="admin.php?page=likedome/admin/group.php&matchId=<?php echo $match->id;  ?>&category=schedule"><?php echo $match->name; ?></a></strong></td>
            <td><?php echo ($matchtypelist[intval($match->type)]->type); ?></td>
            <td><select name="stageselect" id="stageselect">
                <option value='1' <?php if($match->stage == 1)  echo 'selected="selected"'; ?> >报名中</option>
                <option value='2' <?php if($match->stage == 2)  echo 'selected="selected"'; ?> >进行中</option>
                <option value='3' <?php if($match->stage == 3)  echo 'selected="selected"'; ?> >已结束</option>
            </select> </a></td>
            <td><?php echo $match->grouplimit; ?></td>
            <td><?php echo $match->groupmemberlimit; ?></td>
            <td><strong><a href="admin.php?page=likedome/admin/group.php&matchId=<?php echo $match->id;  ?>"><?php echo $match->groupnumber; ?></a></strong></td>
            <td><input name="matchid" type="hidden" value="<?php echo $match->id; ?>" /><input name="category" type="hidden" value="update" /><input type="submit" name="update"  value="提交" /></td>
            </form>
            <form method="post">
            <td><input name="matchid" type="hidden" value="<?php echo $match->id; ?>" /><input name="category" type="hidden" value="del" /><input type="submit" name="delete" value="删除" /></td>
            </form>
        </tr>
    <?php endforeach; ?>
    <?php if ($tpl->getVar('paging') == 1) : ?> 
        <tr >
            <td colspan="5">
            <div class="ym">
                <a href="#">上一页</a>共2页面<a href="#" class="dqym">1</a><a href="#">2</a><a href="#">下一页</a>
            </div></td>
            <td colspan="6" />
        </tr>
    <?php endif;  ?>
</table>