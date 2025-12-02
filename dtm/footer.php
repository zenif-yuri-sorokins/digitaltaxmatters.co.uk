<?php
    list($app, $config) = init();
    
    $layout = $app->loader('layout');
?>
<footer id="footer">
    <div id="footer-main" class="<?php echo $layout->get_sc_layout()['section']; ?>">
        <div class="<?php echo $layout->get_sc_layout()['container']; ?>">
            <div class="gi-row t-a-c main-area">
                <div class="gi-col-sm-12">
                    <a class="logo" href="/" title="<?php echo $config->read('company/name'); ?>">


                    	<?php
										$logo = (date('F') === 'December')
											? '/images/christmas-logo-blue.png'
											: '/images/digital-tax-matters-blue.png'
										?>
                        <img src="<?php echo get_template_directory_uri() . $logo  ?>" alt="<?php echo $config->read('company/name'); ?>" />
                    </a>
                    <ul class="contact">
                        <li class="telephone"><?php echo do_shortcode('[company-telephone]'); ?></li>
                        <li class="email"><?php echo do_shortcode('[company-email]'); ?></li>
                    </ul>
                    <?php
                        echo do_shortcode('[company-social-links class="inline"]');
                    ?>
                </div>
            </div>
            <div class="gi-row t-a-c">
                <div class="gi-col-sm-12">
                    <p class="copyright">&copy; <?php echo date('Y'); ?> <?php echo $config->read('company/name'); ?> - <a href="http://www.gudideas.co.uk" title="Web Design" target="_blank" rel="noopener">Web Design</a> and <a href="http://www.gudideas.co.uk" title="SEO" target="_blank" rel="noopener">SEO</a> by Gud Ideas</p>
                    <ul class="other inline">
                        <li><a href="/areas-we-cover" title="Areas We Cover">Areas We Cover</a></li>
                        <li><a href="/data-protection-policy" title="GDPR Policy">GDPR Policy</a></li>
                        <li><a href="/website-terms-and-conditions" title="Website T&C's">Website T&C's</a></li>
                        <li><a href="/sitemap" title="Sitemap">Sitemap</a></li>
                        <li><a href="/sitemap_index.xml" title="XML Sitemap" target="_blank">XML Sitemap</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-bg">
            <div class="clouds animated backgroundScroll"></div>
            <div class="background animated backgroundScrollAlt"></div>
            <div class="foreground animated backgroundScrollAlt"></div>
        </div>
    </div>
</footer>
<?php
    $allowed_pages_hb = array(284, 348, 3465);

    if(is_front_page() || in_array(get_the_ID(), $allowed_pages_hb)):
?>
    <div class="home-logos-box">
        <span class="heading">In Partnership With</span>
        <ul>
            <li>
                <a href="/partners#xero" title="Xero">
                    <img src="/wp-content/uploads/2023/11/xero2.png" alt="Xero" />
                </a>
            </li>
			  <li class="">
                <a href="/partners#xero" title="Xero">
                    <img src="/wp-content/uploads/2023/11/xero-partner-platinum.png" alt="Xero Champion Partner" />
                </a>
            </li>
			<!--
            <li class="">
                <a href="/partners#xero" title="Xero">
                    <img src="/wp-content/uploads/2023/11/xero-partner.png" alt="Xero Champion Partner" />
                </a>
            </li>-->
            <li>
                <a href="/partners#dext" title="Receipt Bank">
                    <img src="/wp-content/uploads/2023/11/dext1.png" alt="Dext" />
                </a>
            </li>
        </ul>
    </div>
<?php
    endif;
?>
<a id="move-up-toggle" href="javascript:void(0);"><i class="fal fa-chevron-up"></i></a>
</div>
</div>
</div>
<?php wp_footer(); ?>
</body>
</html>