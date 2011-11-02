<?php   
global $tpl; 
$groups = $tpl->getVar('groups'); 
$matchId = $tpl->getVar('matchId'); 
$rid = $tpl->getVar('rid');
$scheduleList = $tpl->getVar('scheduleList'); ?>

<table class="widefat" style="line-height: 30px;">
	<thead>
		<tr>
			<th width="10%" align="center" >队伍</th>
			<th width="5%" align="center" >&nbsp;</th>
			<th width="10%" align="center" >队伍</th>
			<th width="10%" align="center" >轮次</th>
			<th width="15%" align="center" >开始</th>
			<th width="15%" align="center" >结束</th>
			<th width="15%" align="center" >战绩</th>
			<th width="10%" align="center" >提交</th>
		</tr>
	</thead>
	<tbody id="manage_polls2">
		<?php $countSize = (count($groups)/2); $count = 1;
		foreach ($scheduleList as $schedule) : 
			drawScheduleList($groups, $schedule->mid, $schedule->rid, $schedule->ngid, $schedule->sgid, $schedule->round, $schedule->begin, $schedule->end, $schedule->result);
			$count++;
		endforeach;
		for ($i = ($count - 1); $i < $countSize; $i++) :
			drawScheduleList($groups, $matchId, $rid, $count);
		endfor; ?>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<th>&nbsp;</th>
			<th><a href="admin.php?page=likedome/admin/group.php&rid=<?php echo intval($rid)+1; ?>&matchId=<?php echo $matchId; ?>&category=schedule">点击进入下一场对阵图</a></th>
			<th><a href="#"></a></th>
			<th>&nbsp;</th>
		</tr>
	</tbody>
</table>