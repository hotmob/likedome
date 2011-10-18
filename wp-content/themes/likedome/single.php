<?php get_header(); ?>
<div id="content" class="margin-l18 flo width-600">
    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <?php while (have_posts()) : ?>
            <?php the_post(); ?>
            <?php
            if (function_exists('bcn_display')) {
                echo '<p class="breadcrumb">';
                bcn_display();
                echo '</p>';
            }
            ?>	
            <h1 class="h1"><?php the_title(); ?></h1>
            <div class="pageTitle">
                <span><?php the_time(get_option('date_format')); ?></span>
                <span><?php the_category(', '); ?></span>
                <span><a href="#">发布:<?php the_author_link(); ?></a></span>
            </div>
            <div class="content">
                <?php the_content(); ?>
                <?php wp_link_pages(array('before' => '<p class="pages"><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
            </div>
            <div class="share margin-t22"> <span class="fl">分享我吧：</span>
                <!-- JiaThis Button BEGIN -->
                <div id="jiathis_style_32x32"> <a class="jiathis_button_qzone"></a> <a class="jiathis_button_tsina"></a> <a class="jiathis_button_tqq"></a> <a class="jiathis_button_renren"></a> <a class="jiathis_button_kaixin001"></a> <a href="http://www.jiathis.com/share" class="jiathis jiathis_txt jtico jtico_jiathis" target="_blank"></a> <a class="jiathis_counter_style"></a> </div>
                <script type="text/javascript" src="http://v2.jiathis.com/code/jia.js" charset="utf-8"></script>
                <!-- JiaThis Button END -->
            </div>
            <?php comments_template('', true); ?>
            <?php endwhile; ?>
    </div>
</div>
<?php get_sidebar(); ?>
<div class="clear"></div>
<?php get_footer(); ?>