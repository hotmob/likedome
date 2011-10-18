<?php
/*
  Template Name: Archive
 */
?>
<?php get_header(); ?>
<div id="content" class="margin-l18 flo width-600">
    <div id="content" class="content-group content-author">
        <div class="pad">
            <div class="post-group">
                <?php the_post(); ?>
                <div class="content-title">
                    <h1 class="title">Posts By <?php the_author(); ?></h1>
                </div>
                <?php rewind_posts(); ?>		
                <?php get_template_part('loop', 'archive'); ?>
            </div>
        </div>
    </div>
</div>	
<?php get_sidebar(); ?>

<?php get_footer(); ?>