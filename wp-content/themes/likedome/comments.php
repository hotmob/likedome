<?php
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME'])) {
    die('Please do not load this page directly. Thanks!');
}
?>
<br><br>
<div class="comment margin-t50">
    <div class="comment-title">
        <h3 class="fl">网友评论：</h3><code class="fr"></code>
    </div>
    <ul class="comment-list">
        <?php if (post_password_required()) : ?>
            <li><div class="comment-listInfo">本篇文章需要登陆才能发表评论.</div></li>
        <?php elseif (!empty($comments_by_type['comment'])) : ?>
            <?php wp_list_comments('type=comment&callback=mytheme_comment'); ?>
        <?php else : ?>
            <li><div class="comment-listInfo">这篇文章还没有人参与评论.</div></li>
        <?php endif; ?>
    </ul>
    <div class="clear"></div>
    <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
    <div class="pageNoComment">
        <?php paginate_comments_links('prev_text=上一页&next_text=下一页'); ?>
    </div>
    <?php endif; ?>
</div>
<?php if (comments_open()) : ?>
    <a name="reply"></a>
    <div class="comment-form margin-t22" id="reply">
        <?php if (get_option('comment_registration') && !is_user_logged_in()) : ?>
            <p>你必须<a href="<?php echo wp_login_url(get_permalink()); ?>">登陆</a>才能发表评论.</p>
        <?php else : ?>
            <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="comment-form">
                <?php if (is_user_logged_in()) : ?>
                    <p>使用用户名:<a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>发表评论或者<a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account">退出登陆 &raquo;</a></p>
                <?php else : ?>
                    <p class="margin-t6">
                        <label>用户名：</label><input class="comment-text1" type="text" name="author" id="comment-author" value="<?php echo '' != esc_attr($comment_author) ? esc_attr($comment_author) : ''; ?>" size="22" tabindex="1" />
                    </p>
                <?php endif; ?>
                    <p class="margin-t6">
                        <textarea name="comment" id="comment-comment" cols="22" rows="5" tabindex="4"></textarea>
                    </p>
                    <p class="margin-t6">
                        <button class="fr" type="submit" name="submit" value="submit" id="comment-submit" tabindex="5" ><span>发表评论</span></button>
                        <small><?php cancel_comment_reply_link(); ?></small>
                    </p>
                    <div class="clear"></div>
                <?php comment_id_fields(); ?>
                <?php do_action('comment_form', $post->ID); ?>
            </form>
        <?php endif; ?>
    </div>
<?php endif; ?>
