<?php
/*
 * Template Name: Polls
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php  get_header();?>

<div class="margin-l18 flo width-600">
	<div class="pad">
		<style type="text/css">
			* {
				margin: 0;
				padding: 0;
				list-style: none;
			}
			img {
				border: 0;
			}
			body {
				font-size: 12px;
				font-family: Tahoma, Arial, Verdana, Helvetica, sans-serif;
				color: #353535;
			}
			.dialog-box {
				position: absolute;
				z-index: 1001
			}
			.dialog-popup {/*background-color:#333333\9;*/
				filter: progid :DXImageTransform.Microsoft.gradient(enabled='true',startColorstr='#7F333333', endColorstr='#7F333333');
				position: relative;
				z-index: 29;
				zoom: 1;
				background: rgba(51,51,51,0.5);
				padding: 10px;
			}
			.dialog-popup .dialog-title-bar {
				height: 30px;
				background-color: #CDCDCD;
				position: relative;
			}
			.dialog-popup .dialog-title-bar h2 {
				line-height: 30px;
				padding-left: 10px;
				font-size: 14px;
				font-weight: 700
			}
			.dialog-popup .dialog-title-bar a.close-dialog {
				position: absolute;
				top: 5px;
				right: 10px;
				background-color: #FFFFFF;
				border: 1px solid #FF3300;
				font-size: 14px;
				font-weight: 700;
				display: block;
				height: 18px;
				width: 18px;
				line-height: 18px;
			}
			.dialog-popup .dialog-title-bar a.close-dialog {
				text-decoration: none;
				color: #555555;
				text-align: center;
			}
			.dialog-popup .dialog-title-bar a.close-dialog:hover {
				text-decoration: none;
				color: #333333
			}
			.dialog-content {
				background-color: #FFFFFF;
				padding: 10px
			}
			.dialog-iframe-mask {
				position: absolute;
				left: 0;
				top: 0;
				border: none;
			}
			.boxy-modal-blackout {
				position: absolute;
				left: 0;
				top: 0;
				border: none;
				background-color: #333333;
				overflow: hidden;
				z-index: 999
			}
		</style>
		<?php if (function_exists('vote_poll') && !in_pollarchive()): ?>
			<?php
                $related = $wpdb->get_results("
                SELECT pollq_id
                FROM {$wpdb->prefix}pollsq
                WHERE {$wpdb->prefix}pollsq.pollq_active = 1 
                LIMIT 10");
                foreach ($related as $id) {
                	get_poll($id->pollq_id);
				} ?>
		<?php  endif;?>
	</div>
	</div>
	<?php  get_sidebar();?>
</div>
<?php get_footer();?>