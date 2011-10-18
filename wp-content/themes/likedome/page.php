<?php get_header(); ?>
<div id="content" class="margin-l18 flo width-600">
    <div class="pad">
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
    </div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>