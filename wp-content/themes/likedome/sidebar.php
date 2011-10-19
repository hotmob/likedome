
    <div id="sidebar" class="margin-r18 fro width-300">
<!--        <div class="box box-search">
            <div class="title">
                <h3>Search</h3>
            </div>
            <div class="interior">
                <?php get_search_form(); ?>
            </div>
        </div>-->
        <div class="title2">
            <h3 class="flo">热门新闻</h3>
            <code class="fro margin-r10"><a href="?cat=5">更多</a></code>
            <div class="clear"></div>
        </div>
        <div id="tab1">
            <ul class="tab_menu sideMenu">
                <li class="select">最新新闻</li>
                <li>历史新闻</li>
                <li>官方新闻</li>
            </ul>
            <div class="clear"></div>
            <div class="topNews margin-t18">
            	<?php $queryObject = new WP_Query('posts_per_page=1&cat=11');
                    if ($queryObject->have_posts()) : while ($queryObject->have_posts()) :$queryObject->the_post();?>
            	<a href="<?php the_permalink(); ?>" target="_blank" class="fl" title="<?php the_title_attribute(); ?>" ><?php the_post_thumbnail(); ?></a>
                <div class="fro topNews-text">
                    <h4><?php the_title_attribute(); ?></h4>
                    <p class="margin-t6"><?php  the_excerpt()  ?></p>
                </div>
                <?php endwhile; endif;?>
                <div class="clear"></div>
            </div>
            <ul class="sideTab-list margin-t13 tab_main">
                <?php wp_get_archives('type=postbypost&limit=10&format=custom&before=<li>* &after=</li>'); ?><!-- 最新文章-->
            </ul>
            <ul class="sideTab-list margin-t13 tab_main">
                <?php
                $cats = wp_get_post_categories(1);
                if ($cats) {
                $related = $wpdb->get_results("
                SELECT post_title, ID
                FROM {$wpdb->prefix}posts, {$wpdb->prefix}term_relationships, {$wpdb->prefix}term_taxonomy
                WHERE {$wpdb->prefix}posts.ID = {$wpdb->prefix}term_relationships.object_id
                AND {$wpdb->prefix}term_taxonomy.taxonomy = 'category'
                AND {$wpdb->prefix}term_taxonomy.term_taxonomy_id = {$wpdb->prefix}term_relationships.term_taxonomy_id
                AND {$wpdb->prefix}posts.post_status = 'publish'
                AND {$wpdb->prefix}posts.post_type = 'post'
                AND {$wpdb->prefix}term_taxonomy.term_id = '" . $cats[0] . "'
                AND {$wpdb->prefix}posts.ID != '" . $post->ID . "'
                ORDER BY RAND( )
                LIMIT 10");
                if ( $related ) {
                    foreach ($related as $related_post) {
                ?>
                    <li>* <a href="<?php echo get_permalink($related_post->ID); ?>" rel="bookmark" title="<?php echo $related_post->post_title; ?>"><?php echo $related_post->post_title; ?></a></li>
                <?php  } } else { ?>
                    <li>* 暂无相关文章</li>
                <?php } }?>
            </ul>
            <ul class="sideTab-list margin-t13 tab_main">
            <?php
//                $post_tags = wp_get_post_tags($post->ID);
//                if ($post_tags) {
//                    foreach ($post_tags as $tag) {
//                        // 获取标签列表
//                        $tag_list[] .= $tag->term_id;
//                    }
//                    // 随机获取标签列表中的一个标签
//                    $post_tag = $tag_list[mt_rand(0, count($tag_list) - 1)];
                    // 该方法使用 query_posts() 函数来调用相关文章，以下是参数列表
                    $args = array(
                        'tag__in' => array(9), // TAG ID
                        'category__not_in' => array(NULL), // 不包括的分类ID
                        'post__not_in' => array($post->ID),
                        'showposts' => 10, // 显示相关文章数量
                        'caller_get_posts' => 1
                    );
                    query_posts($args);
                if (have_posts()) :
                    while (have_posts()) : the_post();
                        update_post_caches($posts); ?>
                <li>* <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
            <?php endwhile; else : ?>
                <li>* 暂无相关文章</li>
            <?php endif; wp_reset_query();// } ?>
            </ul>
        </div>

        <!--热门视频-->
        <div class="title2 margin-t18">
            <h3 class="flo">热门视频</h3>
            <code class="fro margin-r10"><a href="?cat=4" target="_blank">更多</a></code>
            <div class="clear"></div>
        </div>
        <div id="tab2">
            <ul class="tab_menu sideMenu">
                <li class="select">热门视频</li>
                <li>往期推荐</li>
            </ul>
            <div class="clear"></div>
            <ul class="playerList side-playerList tab_main">
                <?php
                    $query = 'posts_per_page=5&cat=4';
                    $queryObject = new WP_Query($query);
                    if ($queryObject->have_posts()) : while ($queryObject->have_posts()) :$queryObject->the_post();?>
                    <li><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail(); ?></a><div class="icon-camara1"></div></li>
                <?php endwhile; endif;?>
            </ul>
            <ul class="playerList side-playerList tab_main">
                <?php
                    function filter_old($where){
                        $where .= " AND post_date < '" . date('Y-m-d', strtotime('0 hour ')) . "'";
                        return $where;
                    }
                    add_filter('posts_where', 'filter_old');
                    $query = 'posts_per_page=5&cat=4';
                    $queryObject = new WP_Query($query);
                    if ($queryObject->have_posts()) : while ($queryObject->have_posts()) :$queryObject->the_post();?>
                    <li><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail(); ?></a><div class="icon-camara1"></div></li>
                <?php endwhile; endif;?>
            </ul>
        </div>
        <div class="clear"></div>
        <!--选手得分榜-->
        <div class="title2 margin-t18">
            <h3 class="flo">选手人气排行榜</h3>
            <code class="fro margin-r10"><a href="#">更多</a></code>
            <div class="clear"></div>
        </div>
        <div id="tab3">
            <ul class="tab_menu sideMenu">
                <li class="select">羽毛球</li>
                <li>篮球</li>
                <li>排球</li>
            </ul>
            <div class="clear"></div>
            <ul class="topList margin-t13 tab_main">
                <li><code>213123</code><span class="icon-topList1">1</span><span>碉堡</span></li>
                <li><code>213123</code><span class="icon-topList1">2</span><span>碉堡</span></li>
                <li><code>213123</code><span class="icon-topList1">3</span><span>碉堡</span></li>
                <li><code>213123</code><span class="icon-topList2">4</span><span>碉堡</span></li>
                <li><code>213123</code><span class="icon-topList2">5</span><span>碉堡</span></li>
                <li><code>213123</code><span class="icon-topList2">6</span><span>碉堡</span></li>
                <li><code>213123</code><span class="icon-topList2">7</span><span>碉堡</span></li>
                <li><code>213123</code><span class="icon-topList2">8</span><span>碉堡</span></li>
                <li><code>213123</code><span class="icon-topList2">9</span><span>碉堡</span></li>
                <li><code>213123</code><span class="icon-topList2">10</span><span>碉堡</span></li>
            </ul>
            <ul class="topList margin-t13 tab_main">
                <li><code>213123</code><span class="icon-topList1">1</span><span>碉堡</span></li>
                <li><code>213123</code><span class="icon-topList1">2</span><span>碉堡</span></li>
                <li><code>213123</code><span class="icon-topList1">3</span><span>碉堡</span></li>
                <li><code>213123</code><span class="icon-topList2">4</span><span>碉堡</span></li>
                <li><code>213123</code><span class="icon-topList2">5</span><span>碉堡</span></li>
                <li><code>213123</code><span class="icon-topList2">6</span><span>碉堡</span></li>
                <li><code>213123</code><span class="icon-topList2">7</span><span>碉堡</span></li>
                <li><code>213123</code><span class="icon-topList2">8</span><span>碉堡</span></li>
                <li><code>213123</code><span class="icon-topList2">9</span><span>碉堡</span></li>
                <li><code>213123</code><span class="icon-topList2">10</span><span>碉堡</span></li>
            </ul>
            <ul class="topList margin-t13 tab_main">
                <li><code>213123</code><span class="icon-topList1">1</span><span>碉堡</span></li>
                <li><code>213123</code><span class="icon-topList1">2</span><span>碉堡</span></li>
                <li><code>213123</code><span class="icon-topList1">3</span><span>碉堡</span></li>
                <li><code>213123</code><span class="icon-topList2">4</span><span>碉堡</span></li>
                <li><code>213123</code><span class="icon-topList2">5</span><span>碉堡</span></li>
                <li><code>213123</code><span class="icon-topList2">6</span><span>碉堡</span></li>
                <li><code>213123</code><span class="icon-topList2">7</span><span>碉堡</span></li>
                <li><code>213123</code><span class="icon-topList2">8</span><span>碉堡</span></li>
                <li><code>213123</code><span class="icon-topList2">9</span><span>碉堡</span></li>
                <li><code>213123</code><span class="icon-topList2">10</span><span>碉堡</span></li>
            </ul>
        </div>
        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>
        <?php endif; ?>
    </div>
    <div class="clear"></div>

<?php if (is_home()) : ?>
    <div class="note">
        <h4 class="margin-t6 margin-l6 fl">对本平台有何不同的观点，点击这里提交你的建议，采纳有奖哦^-^</h4>
        <code class="fro margin-t4 padding-r6"><a href="#" class="btn2 textOver suggest-open">发表意见</a></code>
    </div>
<?php endif; ?>