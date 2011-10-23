<?php
/*
 Template Name: blank
 */
?>
<?php while (have_posts()) : ?>
    <?php the_post(); ?>
    <div class="content">
        <?php the_content(); ?>
    </div>
<?php endwhile; ?>