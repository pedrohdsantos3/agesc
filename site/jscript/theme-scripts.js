(function ($) {
    "use strict";

	var $ = jQuery.noConflict();

	Array.prototype.forEach2=function(a){ var l=this.length; for(var i=0;i<l;i++)a(this[i],i) };

	jQuery(document).on("ready", function() {

		jQuery("[data-ot-css]", "body").toArray().forEach2(function(a){
			var thisel = jQuery(a);
			thisel.attr("style", thisel.data("ot-css"));
		});

		// Sets retina images @2x
		var retina = window.devicePixelRatio > 1;
		if(retina) {
			jQuery(".retina-check", "body").toArray().forEach2(function(a){
				jQuery(a).addClass("go-retina");
			});
			var n = 0;
			jQuery("img[data-ot-retina]", "body").toArray().forEach2(function(a){
				var thisel = jQuery(a);
				var theImage = new Image();
				if(thisel.data("ot-retina") == "") return false;
				theImage.src = thisel.attr("src");
				jQuery(theImage).load(function(){
					var thisnew = jQuery(this);
					thisel.attr("src", generatePlaceholder(thisnew[0].width,thisnew[0].height));
					thisel.css({
						"background-image": "url('"+thisel.data("ot-retina")+"')",
						"background-size": "100% 100%",
						"background-repeat": "none"
					});
				});
			});
		}

		jQuery("strong", ".composs-panel-title-tabbed").on("click", function(){
			var thisel = jQuery(this),
				thisindex = thisel.index();
			thisel.addClass("active").siblings(".active").removeClass("active").parent().siblings(".composs-panel-inner").children(".composs-panel-tab").eq(thisindex).addClass("active").siblings(".active").removeClass("active");
			// To show slider even in tabbed
			// initiateLetsDoSlider();
			var thislider = thisel.parent().siblings(".composs-panel-inner").find(".composs-panel-tab.active .lets-do-slider");
			if(thislider.length){
				var carousel = thislider.data('owlCarousel');
				carousel._width = thislider.width();
				carousel.invalidate('width');
				carousel.refresh();
			}
		});

		jQuery('.ot-w-gallery-list .item-header').owlCarousel({
			loop: true,
			margin: 20,
			responsiveClass: true,
			items: 1,
			nav: true,
			loop: false
		});

		jQuery('.composs-photo-gallery-list .item-header').owlCarousel({
			loop: true,
			margin: 20,
			responsiveClass: true,
			items: 1,
			nav: true,
			dots: false,
			loop: false
		});


		jQuery("#main-menu .wrapper > ul > li").on("mouseenter", function(){
			var thisel = jQuery('.ot-w-gallery-list .item-header');
			if(thisel.length){
				var carousel = thisel.data('owlCarousel');
				carousel._width = thisel.width();
				carousel.invalidate('width');
				carousel.refresh();
			}
		});

		jQuery(".lets-do-slider").each(function(){
			var thisel = jQuery(this);
			if(thisel.hasClass("lets-do-2")){
				var n = 2;
			}else
			if(thisel.hasClass("lets-do-3")){
				var n = 3;
			}else
			if(thisel.hasClass("lets-do-4")){
				var n = 4;
			}else
			if(thisel.hasClass("lets-do-5")){
				var n = 5;
			}else{
				var n = 1;
			}
			thisel.owlCarousel({
				dots: true,
				margin: 30,
				responsive: {
					0: {
						items: 1
					},
					600: {
						items: n
					}
				}
			});
		});

		// Photo Gallery thumbs navigation
		jQuery("body").delegate(".content-photo-thumbs button", "click", function(){
			var thisel = jQuery(this),
				marginHandler = thisel.siblings(".photo-gallery-thumbs-inner").children(".item").eq(0),
				current = thisel.siblings(".photo-gallery-thumbs-inner").data("thumbs-start-from");

			if(thisel.hasClass("photo-gallery-nav-left")){
				if(current+216 >= 0){
					current = 0;
					thisel.siblings(".photo-gallery-thumbs-inner").removeClass("not-first").removeClass("is-last");
				}else{
					current = current+216;
					thisel.siblings(".photo-gallery-thumbs-inner").removeClass("is-last");
				}
			}else
			if(thisel.hasClass("photo-gallery-nav-right")){
				var maxsize = (thisel.siblings(".photo-gallery-thumbs-inner").children(".item").size()*(80+8))-parseInt(jQuery(".photo-gallery-thumbs-inner", ".content-photo-thumbs").width(), 10);

				if(current-216 <= (-1)*maxsize){
					if(maxsize > 0){
						current = (-1)*maxsize;
						thisel.siblings(".photo-gallery-thumbs-inner").addClass("is-last");
					}
				}else {
					current = current-216;
					thisel.siblings(".photo-gallery-thumbs-inner").addClass("not-first").removeClass("is-last");
				}
			}

			marginHandler.css("margin-left", current+"px");
			thisel.siblings(".photo-gallery-thumbs-inner").data("thumbs-start-from", current);
			return false;
		});

		jQuery(".lightbox", "body").on("click", function () {
			var thisel = jQuery(this);
			thisel.css('overflow', 'hidden');
			jQuery("body").css('overflow', 'auto');
			thisel.find(".lightcontent").fadeOut('fast');
			thisel.fadeOut('slow');
		}).children().on("click", function (e) {
			return false;
		});

		jQuery(".lightbox .light-close", "body").on("click", function(){
			jQuery(".lightbox").click();
			return false;
		});


		// data-res-menu-title="Main Menu"

		jQuery("#main-menu > ul").toArray().forEach2(function(key){
			var thisel = jQuery(key);
			jQuery("#responsive-menu-holder").append(thisel.html());
		});


		jQuery(".ot-responsive-menu-header-burger", ".ot-responsive-menu-header").on("click", function(){
			var mybody = jQuery("body"),
				mex_top = "-"+parseInt(jQuery(document).scrollTop(), 10)+"px";
			if(!mybody.hasClass("nomorefixd"))
			mybody.addClass("ot-responsive-menu-show").addClass("nomorefixd").children(".boxed").css({"margin-top": mex_top});
			jQuery(document).scrollTop( (jQuery(".ot-responsive-menu-content-inner").hasClass("has-search"))?76:0 );
			return false;
		});

		jQuery(".ot-responsive-menu-header-burger", ".ot-responsive-menu-content-c-header").on("click", function(){
			var mybody = jQuery("body");
			if(mybody.hasClass("nomorefixd")){
				mybody.removeClass("ot-responsive-menu-show");
				setTimeout(function(){
					var mex_top = Math.abs(parseInt(jQuery(".boxed", "body").css("margin-top")));
					jQuery(".boxed", "body").removeAttr("style");
					mybody.removeClass("nomorefixd");
					jQuery(document).scrollTop( mex_top );
				}, 200);
			}
			return false;
		});

		jQuery("body").delegate(".boxed", "click", function(){
			var mybody = jQuery("body");
			if(mybody.hasClass("nomorefixd")){
				mybody.removeClass("ot-responsive-menu-show");
				setTimeout(function(){
					var mex_top = Math.abs(parseInt(jQuery(".boxed", "body").css("margin-top")));
					jQuery(".boxed", "body").removeAttr("style");
					mybody.removeClass("nomorefixd");
					jQuery(document).scrollTop( mex_top );
				}, 200);
			}
		});

	});

	var menuisfollowing = false;

	jQuery(window).on("scroll", function(){

		// Refreshes fixed main menu position
		var wr = jQuery(".ot-menu-will-follow .main-menu-placeholder").children(),
			wrfollow = jQuery(".ot-menu-will-follow .is-now-following");

		if(wr.size() > 0 && jQuery(window).scrollTop() >= parseInt(wr.parent().offset().top, 10)+280){
			wr.addClass("smallify");
		}else if(wrfollow.size() > 0 && jQuery(window).scrollTop() < parseInt(wrfollow.parent().offset().top, 10)+280){
			wrfollow.removeClass("smallify");
		}

		if(wr.size() > 0 && jQuery(window).scrollTop() >= parseInt(wr.parent().offset().top, 10) && menuisfollowing == false){
			menuisfollowing = true;
			wr.parent().css({"height": wr.parent().height()});
			wr.addClass("is-now-following");
		}else if(wrfollow.size() > 0 && jQuery(window).scrollTop() < parseInt(wrfollow.parent().offset().top, 10) && menuisfollowing == true){
			menuisfollowing = false;
			wrfollow.removeClass("is-now-following").parent().css({"height": "auto"});
		}
	});

	// Generating retina placeholder image
	function generatePlaceholder(w, h){
		var canvas = document.createElement('CANVAS'),
			ctx = canvas.getContext('2d'),
			img = new Image;
		canvas.height = h;
		canvas.width = w;
		ctx.drawImage(img,0,0);
		setTimeout(function(){
			canvas = null;
		}, 10);
		return canvas.toDataURL('image/png');
	}

	setTimeout(function(){
		jQuery('.theiaStickySidebar', "body").parent().theiaStickySidebar({
			// Settings
			additionalMarginTop: 30
		});
	}, 100);

})(jQuery);