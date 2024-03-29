

<?php if (!have_posts()) : ?>

<div id="post-0" class="hentry post error404 not-found">
	<div class="title">
		<h2>Not Found</h2>
	</div>
	<div class="content">
		<p>Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.</p>
	</div>
</div>

<?php else : ?>
	<?php 
		add_filter('excerpt_length', 'padd_theme_hook_excerpt_index_length'); 
		$i = '1';
	?>
	<?php while (have_posts()) : ?>
		<?php the_post(); ?>
		<li>
			<h4><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h4>
			<div class="img">
				<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
					<?php
						$padd_image_def = get_template_directory_uri() . '/images/thumbnail.jpg';
						if (has_post_thumbnail()) {
							the_post_thumbnail(PADD_THEME_SLUG . '-thumbnail');
						} else {
							echo '<img src="' . $padd_image_def . '" />';
						}
					?>
				</a>
			</div>
			<?php if ('post' == get_post_type()) : ?>
			<code>
				<span class="date"><?php the_time(get_option('date_format')); ?></span> - 
				<span class="author">Posted by <?php the_author_link(); ?></span> -
				<span class="comments"><a href="<?php comments_link(); ?> "><?php echo comments_number('no comments', '1 comment', '% comments'); ?></a></span>
			</code>
			<?php endif; ?>
			<?php the_excerpt();?>
		</li>
		<?php $i = ($i == '1') ? '2' : '1'; ?>
	<?php endwhile; ?>
	<?php
		remove_filter('excerpt_length', 'padd_theme_hook_excerpt_index_length'); 
	?>
	    </ul>
	    <div class="clear"></div>
		<?php Padd_PageNavigation::render(); ?>
<?php endif; ?>









	
	
