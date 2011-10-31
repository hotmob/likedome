<?php   
global $tpl; 
$groups = $tpl->getVar('groups'); 
$matchId = $tpl->getVar('matchId'); 
$round = $tpl->getVar('round');
$optionString = $tpl->getVar('optionString'); ?>

<table class="widefat" style="line-height: 30px;">
	<thead>
		<tr>
			<th width="9%">比赛队伍</th>
			<th width="2%">&nbsp;</th>
			<th width="9%">比赛队伍</th>
			<th width="6%">轮次</th>
			<th width="13%">开始日期/时间</th>
			<th width="12%">结束日期/时间</th>
			<th width="12%">战绩</th>
		</tr>
	</thead>
	<tbody id="manage_polls2">
		<?php $countSize = (count($groups)/2);
		for ($i = 0; $i < $countSize; $i++) : ?>
			<tr id="poll-5" class="highlight">
				<td>
					<select name="ngid" id="ngid">
						<?php echo $optionString; ?>
					</select>
				</td>
				<td align="center" valign="middle">VS</td>
				<td>
					<select name="sgid" id="sgid">
						<?php echo $optionString; ?>
					</select>
				</td>
				<td><input name="round" type="text" id="round" style="width: 80px;" value="<?php echo $round; ?>" /></td>
				<td><input name="begin" type="text" id="begin" style="width: 180px;" value="例如：2011年10月17日下午5.26" /></td>
				<td><input name="end" type="text" id="end" style="width: 180px;" value="例如：2011年10月17日下午5.26" /></td>
				<td><input name="result" type="text" id="result" style="width: 180px;" value="例如：神魔队10比2战胜奇葩队" /></td>
			</tr>
		<?php endfor; ?>
		<tr>
			<td>
				<input name="matchid" type="hidden" value="<?php echo $matchId; ?>" />
				<input name="category" type="hidden" value="schedule" />
				<input type="submit" value="提交" />
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<th>&nbsp;</th>
			<th><a href="#">点击添加下一场对阵图</a></th>
			<th><a href="#"></a></th>
			<th>&nbsp;</th>
		</tr>
	</tbody>
</table>