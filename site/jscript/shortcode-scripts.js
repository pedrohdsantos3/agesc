(function ($) {
	"use strict";

	Array.prototype.forEach2=function(a){ var l=this.length; for(var i=0;i<l;i++)a(this[i],i) };

	jQuery(document).on("ready", function() {

		// Tabs shortcode
		jQuery(".ot-shortcode-tabs", "body").toArray().forEach2(function(a){
			var thisel = jQuery(a);
			thisel.children("ul").children("li").eq(0).addClass("active");
			thisel.children("div").eq(0).addClass("active");
		})

		jQuery(".ot-shortcode-tabs > ul > li a", "body").on("click", function () {
			var thisel = jQuery(this).parent();
			thisel.siblings(".active").removeClass("active");
			thisel.addClass("active");
			thisel.parent().siblings("div.active").removeClass("active");
			thisel.parent().siblings("div").eq(thisel.index()).addClass("active");
			return false;
		});

		// Accordion blocks
		jQuery(".ot-shortcode-accordion > div > a", "body").on("click", function() {
			var thisel = jQuery(this).parent();
			if (thisel.hasClass("active")) {
				thisel.removeClass("active").children("div").animate({
					"height": "toggle",
					"opacity": "toggle",
					"padding-top": "toggle"
				}, 300);
				return false;
			}
			thisel.siblings("div").toArray().forEach2(function(key) {
				var tz = jQuery(key);
				if (tz.hasClass("active")) {
					tz.removeClass("active").children("div").animate({
						"height": "toggle",
						"opacity": "toggle",
						"padding-top": "toggle"
					}, 300);
				}
			});
			thisel.addClass("active").children("div").animate({
				"height": "toggle",
				"opacity": "toggle",
				"padding-top": "toggle"
			}, 300);
			return false;
		});

		jQuery(".ot-shortcode-alert-message > .close-alert").on("click", function(){
			jQuery(this).parent().hide();
		})
			
	});

	// Sets spacer color
	jQuery("[data-spacer-color]", "body").toArray().forEach2(function(a){
		var thisel = jQuery(a);
		thisel.css({"color": thisel.data("spacer-color"), "background-color": thisel.data("spacer-color")});
	});


})(jQuery);