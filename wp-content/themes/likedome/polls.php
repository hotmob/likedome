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