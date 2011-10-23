<?php
/*
  Template Name: list
 */
?>
<?php get_header(); ?>
<div id="content" class="margin-l18 flo width-600">
    <div class="post-group">
		<h4>比赛酷图</h4>
		<div class="img">
        <li><?php rewind_posts(); ?></li>
        <?php get_template_part('loop', 'list'); ?>
		</div>
		<div class="clear"></div>
    </div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>