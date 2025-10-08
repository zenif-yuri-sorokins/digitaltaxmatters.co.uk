<?php
    list($app) = init();

	$tag = 'h3';
	$_posts = $app->loader('posts');

	if(($wp_query->current_post + $wp_query->post_count) == ($wp_query->post_count)){
		$tag = 'h2';
	}
	
	$title  = '<'. $tag .' class="entry-title">';
	$title .= get_the_title();
	$title .= '</'. $tag .'>';

	$btn_text = (!in_category(3)) ? 'Read Article' : 'View Story';
?>
<article id="post-<?php the_ID(); ?>">
	<a href="<?php echo esc_url(get_permalink()); ?>" title="<?php echo get_the_title(); ?>" class="post-wrapper">
		<div class="post-wrapper-inner">
			<?php
				if(!in_category(3)):
			?>
			<div class="date">
				<span class="day"><?php echo get_the_date('jS'); ?></span>
				<span class="month"><?php echo get_the_date('M'); ?></span>
				<span class="year"><?php echo get_the_date('Y'); ?></span>
			</div>
			<?php
				endif;
			?>
			<div class="img-wrapper" style="background: url('<?php echo $_posts->get_featured_image(false, 'full'); ?>') center 30% / cover;">
			</div>
			<div class="entry-body">
				<?php
					if(!in_category($_posts->config->read('post/exclude_categories'))){
				?>
					<p class="author"><?php echo get_the_author(); ?></p>
				<?php
					}
				?>
				<?php
					echo $title;
				?>
				<div class="entry-content">
					<p class="content"><?php echo trim(substr(strip_tags(do_shortcode(get_the_content())), 0, 99)); ?>...</p>
					<span class="btn btn-default"><?php echo $btn_text; ?></span>
				</div>
			</div>
		</div>
	</a>
</article>