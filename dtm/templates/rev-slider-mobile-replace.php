<?php
list($app, $config) = init();
$device = $app->loader('device');

get_header();
get_title_bar();
?>
<div id="main-content" class="main-content">
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();
			?>
				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<section class="home-slider">
						<?php
							if($device->is_mobile()){
							?>
									<div class="banner-img">
										<div class="banner-content-wrapprer">
											<div class="banner-content">
												<h3 class="banner-heading f-c-white">Heading Here</h3>
												<p class="banner-subheading f-c-white">Some content here</p>
												<a href="/" title="Button Here">Button Here</a>
											</div>
										</div>
									</div>
							<?php
							}
							else{								
								echo do_shortcode('[rev_slider alias="home"]');
							}
						?>
					</section>
					<?php the_content(); ?>
				</div><!-- #post-## -->
			<?php
				endwhile;
			?>
		</div><!-- #content -->
	</div><!-- #primary -->
</div><!-- #main-content -->
<?php
get_footer();