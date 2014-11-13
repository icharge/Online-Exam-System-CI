// ==================================================
// written by designesia
// ==================================================

jQuery(document).ready(function() {
	"use strict";
	// ==================================================
	// change menu on mobile version
	// ==================================================
	domready(function(){
	"use strict";

		selectnav('mainmenu', {
			label: 'Menu',
			nested: true,
			indent: '-'
		});
	});
	

	
	
	
	jQuery(".course-item .hover").hide();
	jQuery(".course-item .inner").hover(
	function() {
	"use strict";
	 jQuery(this).parent().find(".hover").width(jQuery(this).find("img").css("width"));
	 jQuery(this).parent().find(".hover").height(jQuery(this).find("img").css("height"));
	 jQuery(this).parent().find(".hover").fadeTo(150, .9);
	 
	 },
    function() {
	"use strict";
	 jQuery(this).parent().find(".hover").fadeTo(150, 0);
  	})
	
	jQuery(".course-item-small .hover").hide();
	jQuery(".course-item-small .inner").hover(
	function() {
	"use strict";
	 jQuery(this).parent().find(".hover").width(jQuery(this).find("img").css("width"));
	 jQuery(this).parent().find(".hover").height(jQuery(this).find("img").css("height"));
	 jQuery(this).parent().find(".hover").fadeTo(150, .9);
	 
	 },
    function() {
	"use strict";
	 jQuery(this).parent().find(".hover").fadeTo(150, 0);
  	})
	
	// ==================================================
	// prettyPhoto function
	// ==================================================	
	jQuery("area[rel^='prettyPhoto']").prettyPhoto();
	jQuery(".gallery:first a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'fast',theme:'light_square',slideshow:3000, autoplay_slideshow: false});
	jQuery(".gallery:gt(0) a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'fast',slideshow:10000, hideflash: true});
		
	jQuery("#custom_content a[rel^='prettyPhoto']:first").prettyPhoto({
		custom_markup: '<div id="map_canvas" style="width:260px; height:265px"></div>',
		changepicturecallback: function(){ initialize(); }
	});
	jQuery("#custom_content a[rel^='prettyPhoto']:last").prettyPhoto({
		custom_markup: '<div id="bsap_1259344" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div><div id="bsap_1237859" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6" style="height:260px"></div><div id="bsap_1251710" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div>',
		changepicturecallback: function(){ _bsap.exec(); }
	});
	
	
	// ==================================================
	// scroll to top
	// ==================================================	
	jQuery().UItoTop({ easingType: 'easeOutQuart' });
	  
	// ==================================================
	// gallery hover
	// ==================================================	
	jQuery('.gallery .item').hover(function() {
	"use strict";
	jQuery('.gallery .item').not(jQuery(this)).stop().animate({opacity: .3}, 100);
	}, function() {
	"use strict";
	jQuery('.gallery .item').stop().animate({opacity: 1});}, 100);
	
	
	// ==================================================
	// resize
	// ==================================================	
	window.onresize = function(event) {
		jQuery('#gallery').isotope('reLayout');
  	};
	
	window.onload = function(event) {
	// ==================================================
	// filtering gallery
	// ==================================================	
	var $container = jQuery('#gallery');

	$container.imagesLoaded(function() {
	"use strict";
	  $container.isotope({
		itemSelector: '.item',
		filter: '*',
	  });
	});
	
	jQuery('#filters a').click(function(){
		var jQuerythis = jQuery(this);
		if ( jQuerythis.hasClass('selected') ) {
			return false;
			}
		var jQueryoptionSet = jQuerythis.parents();
		jQueryoptionSet.find('.selected').removeClass('selected');
		jQuerythis.addClass('selected');
				
		var selector = jQuery(this).attr('data-filter');
		$container.isotope({ 
		filter: selector,
	});
	return false;
	});
  	};
	
	// ==================================================
	// show / hide slider navigation
	// ==================================================	
	jQuery('.callbacks_nav').hide();
	
	jQuery('#slider').hover(function() {
	"use strict";
	jQuery('.callbacks_nav').stop().animate({opacity: 1}, 100);
	}, function() {
	"use strict";
	jQuery('.callbacks_nav').stop().animate({opacity: 0});}, 100);
	
	
	
	
	jQuery(function () {
      // Slideshow 4
      jQuery(".pic_slider").responsiveSlides({
        auto: true,
        pager: false,
        nav: true,
        speed: 500,
        namespace: "callbacks",
        before: function () {
          jQuery('.events').append("<li>before event fired.</li>");
        },
        after: function () {
          jQuery('.events').append("<li>after event fired.</li>");
        }
      });
    });
	
	
	
	
	// ==================================================
	// lazyload
	// ==================================================	
	 jQuery(function() {
	"use strict";
          jQuery("img").lazyload({
              effect : "fadeIn",
			  effectspeed: 900 
          });
      });


	
	
	
});

