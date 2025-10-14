jQuery(document).ready(function($){
	// Scroll To Top Toggle
	$(window).scroll(function(){
		if($(this).scrollTop() > 300){
			$("#move-up-toggle").fadeIn();
		}
		else{
			$("#move-up-toggle").fadeOut();
		}
	});
	$("#move-up-toggle").click(function(){
		$("html, body").animate({ scrollTop: 0 }, "slow");
  		return false;
	});
	// Mobile Menu - Menu Toggle
	$('.menu-toggle').click(function(){
		if($('.primary-navigation').is(':hidden')){
			$('.primary-navigation').fadeIn();
			$(this).children('i').removeClass('fa-bars');
			$(this).children('i').addClass('fa-times');
			$('body').css({
				overflow: 'hidden'
			});
		}
		else{
			$('.primary-navigation').fadeOut();
			$(this).children('i').removeClass('fa-times');
			$(this).children('i').addClass('fa-bars');
			$('body').css({
				overflow: 'scroll'
			});
		}
	});
	// Mobile Menu - Sub-menu Toggle
	$(".primary-navigation ul li.menu-item-has-children > .arrow").click(function(){
		if(!$(this).parent().children("ul.sub-menu").hasClass('drop')){
			$(this).parent().children("ul.sub-menu").addClass('drop');
			$(this).parent().children("ul.sub-menu").slideDown();
			$(this).children("i").removeClass('fa-angle-down');
			$(this).children("i").addClass('fa-angle-up');
		}
		else{
			$(this).parent().children("ul.sub-menu").removeClass('drop');
			$(this).parent().children("ul.sub-menu").slideUp();
			$(this).children("i").removeClass('fa-angle-up');
			$(this).children("i").addClass('fa-angle-down');
		}
	});
	if($(window).width() > 767){
		// WOW
		new WOW().init();
	}
	if($(window).width() > 991){
		// Paroller
		$('.paroller').paroller();
	}
	/* Banner */
	$(".banner .banner-services ul li").hover(
		function(){
			$('.icon-box', this).not('.in .icon-box').stop(true,true).addClass('animated shake');
		},
		function(){
			$('.icon-box', this).not('.in .icon-box').stop(true,true).removeClass('animated shake');
		}
	);
	// Scroll
	$('.scroll-button-toggle').click(function(){
		$("html, body").animate({ scrollTop: $('#scroll-target').offset().top }, "slow");
  		return false;
	});
	// Banner Scroll Down
	$('.banner .scroll-down a').click(function(){
		$("html, body").animate({ scrollTop: $('#scroll-to').offset().top }, "slow");
  		return false;
	});
	// Count to Number
	$('.count').each(function () {
	  	var $this = $(this);
	  	jQuery({ Counter: 0 }).animate({ Counter: $this.text() }, {
		    duration: 1500,
		    easing: 'swing',
		    step: function () {
		      $this.text(Math.ceil(this.Counter));
		    }
	 	});
	});
	// Privacy Policy
	jQuery(".privacy-policy .pp-list li a").click(function(e){
		var scrollto = $(this).attr('href');
		$("html, body").animate({ scrollTop: $(scrollto).offset().top - 30 }, "slow");
		e.preventDefault();
	});
	// Resource Loader
	jQuery(".resource-loader").click(function(){
		source = jQuery(this).attr('load-source');
		source_tag = jQuery(this).attr('source-tag');

		jQuery(this).addClass('active');

		if(source_tag == 'iframe'){
			jQuery(this).children('.resource-content').html('<iframe src="' + source + '?autoplay=1" width="640" height="360"></iframe>');
		}
	});
	/* Packages */
	jQuery(".package-box").hover(function(e){
		jQuery('.package-box.active').removeClass('active');
		jQuery(this).addClass('active');
	});
	  // FAQs
  $(".faq-link .question-wrapper").click(function () {
    $(".faq-link.active .answer-wrapper").slideUp()
    $(".faq-link.active").removeClass("active")

    if (
      $(this).parents(".faq-link").children(".answer-wrapper").is(":hidden")
    ) {
      $(this).parents(".faq-link").addClass("active")
      $(this).parents(".faq-link").children(".answer-wrapper").slideDown()
    } else {
      $(this).parents(".faq-link").removeClass("active")
      $(this).parents(".faq-link").children(".answer-wrapper").slideUp()
    }

    return false
  })

  $(".pricetable-box-heading").click(function () {
    if (
      $(this).parents(".pricetable-box").children(".pricetable-box-content").is(":hidden")
    ) {
      $(this).parents(".pricetable-box").addClass("active")
      $(this).parents(".pricetable-box").children(".pricetable-box-content").slideDown()
    } else {
      $(this).parents(".pricetable-box").removeClass("active")
      $(this).parents(".pricetable-box").children(".pricetable-box-content").slideUp()
    }

    return false
  })

  const priceToggle = document.getElementById('price-toggle');
  const prices = document.querySelectorAll('.price');
  const priceLabels = document.querySelectorAll('.price-label');

  priceToggle.addEventListener('change', function() {
    if (this.checked) {
      prices.forEach(price => {
        price.innerHTML = `${price.dataset.annually}<span class="price-label">/ann</span> <span class="vat">(+VAT)</span>`;
      });
    //   priceLabels.forEach(label => {
    //     label.textContent = '/ann';
    //   });
    } else {
      prices.forEach(price => {
        price.innerHTML = `${price.dataset.monthly}<span class="price-label">/mo</span> <span class="vat">(+VAT)</span>`;
      });
    //   priceLabels.forEach(label => {
    //     label.textContent = '/mo';
    //   });
    }
  });
});