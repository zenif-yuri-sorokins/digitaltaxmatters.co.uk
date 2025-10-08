<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package grapefruit
 */

get_header(); ?>
<div id="title-bar" class="gi-row-bg bg-c-primary">
    <div class="gi-container">
        <div class="gi-row">
            <div class="gi-col-sm-12">
            	<h1 class="page-heading">
            		<?php printf( esc_html__( 'Search Website For: %s', 'grapefruit' ), '"' . get_search_query() . '"' ); ?>
            	</h1>
            </div>
        </div>
        <div class="gi-row">
            <div class="gi-col-sm-12">
            	<form method="get" class="search-form">
					<div class="gi-row">
						<div class="gi-col-xs-8">
							<input type="text" name="s" value="<?php echo get_search_query(); ?>" />
						</div>
						<div class="gi-col-xs-4">
							<input type="submit" name="submit" value="Search" />
						</div>
					</div>
				</form>
            </div>
        </div>
    </div>
</div>
<section class="custom-section">
	<div id="main" class="site-main" role="main">
		<div class="gi-container">
			<div class="gi-row">
				<div class="gi-col-sm-12">
					<?php
					if ( have_posts() ) : ?>
						<?php
						/* Start the Loop */
						while ( have_posts() ) : the_post();

							/**
							 * Run the loop for the search to output the results.
							 * If you want to overload this in a child theme then include a file
							 * called content-search.php and that will be used instead.
							 */
							get_template_part( 'template-parts/content-search', get_post_format());

						endwhile;

						the_posts_pagination();

					else :

						get_template_part( 'template-parts/content', 'none' );

					endif; ?>
				</div>
			</div>
		</div>
	</div><!-- #main -->
</section><!-- #primary -->
<?php
get_footer();