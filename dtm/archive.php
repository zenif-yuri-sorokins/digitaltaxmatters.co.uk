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
                        <h1 class="banner-heading f-c-white"><?php single_cat_title(); ?></h1>
                        <?php
                        	if(!is_category(3)):
                        ?>
                        <div class="newsletter">
	                        <?php
	                        	echo do_shortcode('[contact-form-7 id="1381" title="Newsletter"]');
	                        ?>
	                    </div>
	                    <?php
	                    	else:
	                    ?>
	                    <p class="banner-content f-c-white">Having over 50 years of experience in the industry, Digital Tax Matters is proud to have built up a client base of over 2,000 different businesses and organisations. Take a look at just some of the clients our knowledgeable accountants have helped to transform!</p>
						<?php
							endif;
						?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="sec <?php echo $layout->get_sc_layout()['section'] ?>">
	<div id="main-content" class="<?php echo $layout->get_sc_layout()['container'];?>">
	    <div class="gi-row">
		    <?php if($layout->get_layout()['sidebar_left_show']): ?>
		        <div class="sidebar-left <?php echo $layout['sidebar_col'];?>">
		        	<?php get_sidebar(); ?>
	        	</div>
		    <?php endif;?>
			<div id="primary" class="content-area gi-col-sm-12">
				<div id="content" class="site-content" role="main">
				<?php
					if(have_posts()):
						$i = 0;

						while(have_posts()):
							if(is_category(3)){
								$i = $wp_query->current_post;
								$i++;
							}

							if(is_category(3)){
								echo ( 0 == $i % 3 ) ? '<div class="post-row-wrapper">' : '';
							}
							else{
								echo ($i % 2 == 0) ? '<div class="post-row-wrapper">' : '';
							}

							the_post();
							get_template_part('template-parts/content', get_post_format());

							if(is_category(3)){
								echo ( $wp_query->post_count == $i || 2 == $i % 3 ) ? '</div>' : '';
							}
							else{
								echo ($i % 2 != 0) ? '</div>' : '';
								$i++;
							}
						endwhile;

						if(is_category(3)){
							echo ($i % 2 != 0) ? '</div>' : '';
						}

						the_posts_pagination();

					else:
						get_template_part('content', 'none');
					endif;
				?>
				</div>
			</div>
		</div>
	</div>
</section>
<?php
get_footer();