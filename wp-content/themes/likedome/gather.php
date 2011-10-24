<?php
/*
  Template Name: gather
 */
?>
<?php get_header(); ?>
<div id="content" class="margin-l18 flo width-600">
	<div class="title">
		<h3 class="flo">热门新闻</h3>
		<code class="fro margin-r10"><a href="?cat=5">更多新闻</a></code>
		<div class="clear"></div>
	</div>
	<ul class="playerList">
		<?php wp_reset_postdata(); ?>
    	<?php $queryObject = new WP_Query('posts_per_page=4&cat=5');
        if ($queryObject->have_posts()) : while ($queryObject->have_posts()) :$queryObject->the_post();?>
        <li><a href="<?php the_permalink(); ?>" target="_blank" title="<?php the_title_attribute(); ?>" >
        	<?php the_post_thumbnail(); ?>
        	</a><div class="icon-camara"></div>
        </li>
        <?php endwhile; endif;?>
        <?php wp_reset_postdata(); ?>
	</ul>
	<div class="title">
		<h3 class="flo">比赛酷图</h3>
		<code class="fro margin-r10"><a href="?cat=3">更多酷图</a></code>
		<div class="clear"></div>
	</div>
	<ul class="playerList">
		<?php wp_reset_postdata(); ?>
    	<?php $queryObject = new WP_Query('posts_per_page=4&cat=3');
        if ($queryObject->have_posts()) : while ($queryObject->have_posts()) :$queryObject->the_post();?>
        <li><a href="<?php the_permalink(); ?>" target="_blank" title="<?php the_title_attribute(); ?>" >
        	<?php the_post_thumbnail(); ?>
        	</a><div class="icon-camara"></div>
        </li>
        <?php endwhile; endif;?>
        <?php wp_reset_postdata(); ?>
	</ul>
	<div class="clear"></div>
	<div class="title margin-t22">
		<h3 class="flo">精彩视频</h3>
		<code class="fro margin-r10"><a href="?cat=4">更多视频</a></code>
		<div class="clear"></div>
	</div>
	<ul class="playerList">
    	<?php $queryObject = new WP_Query('posts_per_page=4&cat=4');
        if ($queryObject->have_posts()) : while ($queryObject->have_posts()) :$queryObject->the_post();?>
        <li><a href="<?php the_permalink(); ?>" target="_blank" title="<?php the_title_attribute(); ?>" >
        	<?php the_post_thumbnail(); ?>
        	</a><div class="icon-camara"></div>
        </li>
        <?php endwhile; endif;?>
        <?php wp_reset_postdata(); ?>
	</ul>
</div>
<?php get_sidebar(); ?>

<?php get_footer(); ?>