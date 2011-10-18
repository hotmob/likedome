<?php
/*
 * Template Name: Polls
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php get_header(); ?>
<div class="margin-l18 flo width-600">
<?php if (function_exists('vote_poll') && !in_pollarchive()): ?>
       <?php //get_poll(1);?>
<?php //display_polls_archive_link(); ?>
<?php endif; ?>


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