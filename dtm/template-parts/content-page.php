<?php
  list($app) = init();

  $_posts = $app->loader('posts');
?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
		echo $_posts->hentry();
	?>
	<div class="entry-content">
		<?php
			the_content();
		?>
	</div>
</div>