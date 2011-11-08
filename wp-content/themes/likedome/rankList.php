<?php
/*
Template Name: Rank List
*/
?>
<?php get_header(); ?>
<div class="vsPos"></div>
<h2 class="busyTitle margin-t22">选手排行榜</h2>
<div class="chaxun">
	<form name="currentSelect" method="post">
		<select name="currentMatchTypeId" id="currentMatchTypeId"
			onChange="document.currentSelect.submit();">
            <?php
				$currentMatchTypeId = intval ( $_POST ['currentMatchTypeId'] );
				$matchTypeList = getMatchTypeList ( OBJECT_K );
				$currentMatchTypeId = drawMatchTypeSelect ( $currentMatchTypeId, 0, $matchTypeList );
				$rankTypeList = getRankTypeList ( - 1, $currentMatchTypeId );
			?>
        </select>
	</form>
</div>
<p class="margin-t10 margin-l80 font-size14"><?php echo $matchTypeList[$currentMatchTypeId]->type; ?></p>
<div class="flo width-400 margin-l80 font-size14 table">
	<table width="800" border="1" cellspacing="0" cellpadding="0">
		<tr>
			<td width="8%" height="24" align="center">排名</td>
			<td width="8%" height="24" align="center">选手</td>
			<?php
			foreach ( $rankTypeList as $rankType ) {
				echo '<th width="8%" height="24" align="center">' . $rankType->name . '</th>';
			}
			?>
		</tr>
		<?php
			$usersRanks = getUserRankList ( - 1, $currentMatchTypeId, - 1, - 1, 1, 0); // ARRAY_A | ARRAY_N | OBJECT | OBJECT_K
			sort($usersRanks);
			foreach ( $usersRanks as $user ) : ?>
		    <tr id="poll-5" class="highlight">
				<td height="24" align="center"><?php echo ++$i; ?></td>
				<td height="24" align="center"><?php $userprofile = getUserProfile($user->uid); echo $userprofile[0]->realname; ?></td>
		        <?php
					foreach ( $rankTypeList as $rankType ) {
						$userRanks = getUserRankList ( $user->uid, $currentMatchTypeId, $rankType->id );
						echo '<td height="24" align="center">'.$userRanks [0]->value .'</td>';
					}
				?>
			</tr>
		<?php endforeach; ?>
	</table>

</div>
<div class="clear"></div>
<!-- <div class="pageNo margin-t18"> -->
<!-- 	<span class="firstpage"><a href="#">首页</a></span><span class="prepage"><a -->
<!-- 		href="#">上一页</a></span><a href="#">1</a><strong>2</strong><a href="#">3</a><a -->
<!-- 		href="#">4</a><a href="#">5</a><a href="#">6</a><a href="#">20</a><span -->
<!-- 		class="nextpage"><a href="#">下一页</a></span><span class="lastpage"><a -->
<!-- 		href="#">尾页</a></span> -->
<!-- </div> -->
</div>
<?php get_footer(); ?>