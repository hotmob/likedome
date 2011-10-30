<?php   global $tpl;  $match = $tpl->getVar('match'); $groups = $tpl->getVar('groups'); ?>
<table class="widefat" style="line-height:30px;">
    <thead>
        <?php if (!empty($match)) :  ?>
        <tr>
            <th width="5%">ID</th>
            <th width="35%">比赛名称</th>
            <th width="10%">队伍数</th>
            <th width="10%">比赛分类</th>
            <th width="10%">队伍上限</th>
            <th width="10%">队员上限</th>
            <th width="20%">状态</th>
        </tr>
        <tr class="highlight">
            <td><strong><?php echo $match->id; ?></strong></td>
            <td><strong><?php echo $match->name; ?></strong></td>
            <td><strong><?php echo $match->groupnumber; ?></strong></td>
            <td><?php echo $match->type; ?></td>
            <td><?php echo $match->grouplimit; ?></td>
            <td><?php echo $match->groupmemberlimit; ?></td>
            <td><?php echo $match->stage; ?></td>
        </tr>
        <?php endif; ?>
        <tr id="poll-6" >
	        <th>参赛队伍</th>
	        <th></th>
	        <th>&nbsp;</th>
	        <th>&nbsp;</th>
	        <th>&nbsp;</th>
	        <th>&nbsp;</th>
	        <th>&nbsp;</th>
        </tr>
        <tr id="poll-7" class="alternate" >
            <td>ID</td>
            <td>队伍名称</td>
             <?php if (!empty($match)) :  ?>
            <td colspan="2"><a href="#">点击下载本次全部队伍详细信息</a></td>
            <td><a href="#">设置对阵图</a></td>
            <td colspan="2">
                <form name= "currentSelect" method= "post">
                    <input name="groupname" type="text" id="groupname" value="输入队伍名称" /><input name="category" type="hidden" value="add" h/><input name="matchId" type="hidden" value="<?php echo $match->id; ?>" h/><input type="submit" value="创建队伍" />
                </form>
            </td>
            <?php else : ?>
            <td colspan="5" width="70%"></td>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach($groups as $group) : ?>
            <tr "poll-7" class="alternate">
                <td><strong><a href="admin.php?page=likedome/admin/member.php&groupId=<?php echo $group->id;  ?>"><?php echo $group->id; ?></a></strong></td>
                <td><strong><a href="admin.php?page=likedome/admin/member.php&groupId=<?php echo $group->id;  ?>"><?php echo $group->name; ?></a></strong></td>
                <td colspan="5"></td>
            </tr>
         <?php endforeach;  ?>
        <tr >
             <?php if ($tpl->getVar('paging') == 1) : ?> 
            <td colspan="7">
                <div class="ym">
                    <a href="#">上一页</a>共2页面<a href="#" class="dqym">1</a><a href="#">2</a><a href="#">下一页</a>
                </div>
            </td>
            <?php endif;  ?> 
        </tr>
    </tbody>
</table>