<?php
/*
Template Name: big page
*/
?>
<?php get_header(); ?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php
    if (function_exists('bcn_display')) {
        echo '<p class="breadcrumb">';
        bcn_display();
        echo '</p>';
    }
    ?>
    <?php while (have_posts()) : ?>
        <?php the_post(); ?>

        <div class="content">
            <?php the_content(); ?>
        </div>

    <?php endwhile; ?>
</div>
<?php get_footer(); ?>