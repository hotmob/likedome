<?php
/*
  Template Name: Category
 */
?>
<?php get_header(); ?>
<div id="content" class="margin-l18 flo width-600">
    <div class="title">
        <h3 class="flo"><?php single_cat_title(); ?></h3>
    </div>
    <ul class="list-xt">
        <?php rewind_posts(); ?>		
        <?php get_template_part('loop', 'category'); ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>