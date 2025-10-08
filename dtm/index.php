<?php
	get_header();

	$layout = $app->loader('layout');
?>
<section class="sec sec-full-width banner banner-service bg-gradient">
    <div class="gi-container-fluid">
        <div class="gi-row">
            <div class="gi-col-sm-12">
                <div class="banner-content-wrapper alt wow fadeIn animated" data-wow-delay="1s">
                    <div class="paroller" data-paroller-factor="0.2" data-paroller-type="foreground" data-paroller-direction="vertical">
                        <h1 class="banner-heading f-c-white">Latest News & Advice</h1>
                        <p class="banner-content f-c-white">Fill the form below to subscribe to receive notifications to include year end reminders, legislation changes and useful tax saving advice.</p>
                        <div class="newsletter">
	                        <?php
	                        	echo do_shortcode('[contact-form-7 id="1381" title="Newsletter"]');
	                        ?>
	                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="sec <?php echo $layout->get_sc_layout()['section']; ?>">
	<div id="main-content" class="<?php echo $layout->get_layout()['width']; ?>">
		<div class="gi-row">
			<?php if($layout->get_layout()['sidebar_left_show']): ?>
				<div class="sidebar-left <?php echo $layout->get_layout()['sidebar_col']; ?>">
					<?php get_sidebar('content'); ?>
				</div> 
			<?php endif; ?>
			<div id="primary" class="content-area <?php echo $layout->get_layout()['primary_col']; ?>">
				<div id="content" class="site-content" role="main">
					<?php
						if(have_posts()):
							$i = 0;

							while (have_posts()):
								the_post();

            					echo ($i % 2 == 0) ? '<div class="post-row-wrapper">' : '';
									get_template_part('template-parts/content', get_post_format());
								echo ($i % 2 != 0) ? '</div>' : '';
								$i++;
							endwhile;

							echo ($i % 2 != 0) ? '</div>' : '';

							the_posts_pagination();
						else:
							get_template_part('content', 'none');
						endif;
					?>
				</div>
			</div>
			<?php if($layout->get_layout()['sidebar_right_show']): ?>
				<div class="sidebar-right <?php echo $layout->get_layout()['sidebar_col']; ?>">
					<?php get_sidebar();?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
<?php
	get_footer();