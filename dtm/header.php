<?php
list($app, $config) = init();

$head = $app->loader('head');
$layout = $app->loader('layout');
$menu = $app->loader('menu');

if ($config->read('vendors/schema')) {
	$schema = $app->loader('schema');
}
?>
<!DOCTYPE html>
<?php
// Load IE Compatibility Tags
echo $head->ie_html_tags();
?>
<html <?php language_attributes(); ?> class="no-js">

<head>
	<?php
	// Load Important Meta and Other Tags
	echo $head->head_tags();
	echo $head->pingback();

	// Load Favicons
	echo $head->load_favicons();

	// Load IE Compatibility Scripts
	echo $head->load_ie_scripts();
	?>

	<?php wp_head(); ?>

	<!-- Google Tag Manager -->
	<script>
		(function(w, d, s, l, i) {
			w[l] = w[l] || [];
			w[l].push({
				'gtm.start': new Date().getTime(),
				event: 'gtm.js'
			});
			var f = d.getElementsByTagName(s)[0],
				j = d.createElement(s),
				dl = l != 'dataLayer' ? '&l=' + l : '';
			j.async = true;
			j.src =
				'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
			f.parentNode.insertBefore(j, f);
		})(window, document, 'script', 'dataLayer', 'GTM-546PMFB');
	</script>
	<!-- End Google Tag Manager -->

	<?php
	// Load Schema Data
	if ($config->read('vendors/schema')) {
		echo $schema->render('LocalBusiness');
	}

	// Load Mobile UI
	echo $head->mobile_status_bar();
	?>
</head>

<body <?php body_class($head->extra_class_body());
		echo $schema->body_schema(); ?>>
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-546PMFB"
			height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
	<a href="#content-area" class="hidden">Skip to main content</a>
	<div id="page" class="site">
		<div class="page-wrapper" <?php echo $schema->page_type_shema(); ?>>
			<div class="site-inner" <?php echo $schema->get_main_entity_schema(); ?>>
				<div class="schema-on-body">
					<?php echo $schema->after_body_schema(); ?>
				</div>



<div class="cta-strip-header bg-c-black">
						<div class="gi-row">
							<div class="gi-col-12">
								<a href="/services/tax-services/making-tax-digital" title="Are you looking to go digital?">Are you looking to go digital? <i class="fa fa-long-arrow-right"></i></a>
							</div>
						</div>
					</div>
				<header id="header">
					<div id="header-main" class="main-header <?php echo $layout->get_sc_layout()['section']; ?>">
						<div class="<?php echo $layout->get_sc_layout()['container']; ?>">

							<div class="gi-row">
								<div class="gi-col-lg-3 gi-col-md-3 gi-col-sm-3 gi-col-xs-7">
									<a class="logo" href="/" title="<?php echo $config->read('company/name'); ?>">
										<img src="<?php echo $config->read('company/logo'); ?>" alt="<?php echo $config->read('company/name'); ?>" />
									</a>
								</div>
								<div class="gi-col-xs-5 hidden-lg hidden-md hidden-sm">
									<a class="menu-toggle" href="javascript:void(0);">
										<i class="fal fa-bars"></i>
									</a>
								</div>
								<nav class="primary-navigation mobile-default gi-col-lg-9 gi-col-md-9 gi-col-sm-9">
									<?php
									$menu->menu_output();
									?>
								</nav>
							</div>
						</div>
					</div>
				</header>
				<div id="content-area" class="site-content">