<?php
	if(!is_active_sidebar('sidebar-1' )){
		return;
	}
?>
<div id="secondary" class="widget-area">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
	<?php
		echo do_shortcode('[action-box class="border-line" bg_gradient_x="0, 0, 0, 0.4" bg_position="center 33%" bg_img="/wp-content/uploads/2019/05/woman-using-laptop-in-office-768x512.jpg" button_link="/contact" button_class="btn-default"]
[action-box-heading]Contact Digital Tax Matters Today[/action-box-heading]
[action-box-content]Modernise Your Business Accounting[/action-box-content]
[/action-box]');
	?>
</div>