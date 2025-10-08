<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package grapefruit
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-body">
		<?php
			if(!is_single()){
				the_title('<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" title="'. get_the_title() .'">', '</a></h3>');
			}
		?>
	</div>
</article><!-- #post-## -->
