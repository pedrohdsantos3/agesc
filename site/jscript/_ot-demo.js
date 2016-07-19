(function ($) {
	"use strict";

	var dat_demo_global = Array(),
	globalitemid = 0;
	if(!dat_img_dir){var dat_img_dir = "images/"}

	jQuery(document).on("ready", function () {
		jQuery('body').append("<div class='demo-settings'><a href='#show-settings' class='demo-button'><img src='images/demo/demo-icon.png' alt='' /><span>Settings</span></a><div class='demo-options'><div class='title'><span>Orange Themes</span><strong>Demo Style Switcher</strong></div><div id='demo-s-wrap'><div class='ot-settings-reset'></div></div><div class='ot-demo-set-foot'><a href='http://themeforest.net/item/portus-responsive-blog-magazine-html-theme/13552039?ref=orange-themes' target='_blank' class='ot-d-buy-button'>Buy Portus</a><a href='' class='ot-d-reset-button'>Reset defaults</a></div></div></div>");

		jQuery(".demo-settings .demo-button").click(function(){
			jQuery(".demo-settings").toggleClass("active");
			return false;
		});
		
		jQuery(".demo-settings").delegate("a[href=#demo]", "click", function(){
			var thiselem = jQuery(this);
			if(thiselem.parent().find("div[rel="+thiselem.attr("rel")+"]").hasClass("thisis") == false){
				thiselem.parent().find("div.thisis").removeClass("thisis").animate({
					height: 'toggle',
					paddingTop: 'toggle',
					opacity: 'toggle'
				}, 150);
				thiselem.addClass("active").siblings(".active").removeClass("active");
			}else{
				thiselem.removeClass("active");
			}
			thiselem.parent().find("div[rel="+thiselem.attr("rel")+"]").toggleClass("thisis").animate({
				height: 'toggle',
				paddingTop: 'toggle',
				opacity: 'toggle'
			}, 150);
			return false;
		});

		jQuery(".ot-settings-reset", ".demo-settings").on("click", function(){
			jQuery(".ot-demo-selector.active .ot-demo-selector-wrap > span.current").click();
		});

		function __dat_demo_css(datDemoID, datDemoValue) {
			for (var i = dat_demo_global[datDemoID].length - 1; i >= 0; i--) {
				if(dat_demo_global[datDemoID][i][3]){
					jQuery(dat_demo_global[datDemoID][i][0]).css(dat_demo_global[datDemoID][i][1], dat_demo_global[datDemoID][i][2] + datDemoValue);
				}else{
					jQuery("head").append("<style>"+dat_demo_global[datDemoID][i][0]+" { "+dat_demo_global[datDemoID][i][1]+": "+(dat_demo_global[datDemoID][i][2] + datDemoValue)+"; }</style>");
				}
				// console.log("#"+datDemoID+ " : "+dat_demo_global[datDemoID][i][0]+ ", "+dat_demo_global[datDemoID][i][2] + dat_demo_global[datDemoID][i][1]);
			};
			return true;
		}

		function __dat_demo_js(datDemoID, datDemoValue) {
			for (var i = dat_demo_global[datDemoID].length - 1; i >= 0; i--) {
				jQuery(dat_demo_global[datDemoID][i][0]).toggleClass(dat_demo_global[datDemoID][i][1]);
				// jQuery("head").append("<style>"+dat_demo_global[datDemoID][i][0]+" { "+dat_demo_global[datDemoID][i][1]+": "+(dat_demo_global[datDemoID][i][2] + datDemoValue)+"; }</style>");
				// console.log("#"+datDemoID+ " : "+dat_demo_global[datDemoID][i][0]+ ", "+dat_demo_global[datDemoID][i][2] + dat_demo_global[datDemoID][i][1]);
			};
			return true;
		}

		function __dat_demo(datDemoID, datDemoGroup, datDemoTitle, datDemoSubDesc, datDemoDescription, datDemoType, datDemoItems, datDemoCSS) {
			if(jQuery("#dat-demo-settings")){

				globalitemid++;

				if(datDemoType == "choise"){
					var build_list = "",build_link = "";
					for (var i = datDemoItems.length - 1; i >= 0; i--) {
						var v = (datDemoItems[i][2])?" active":"";
						build_list = '<a href="javascript:void(0);" class="option-bulb'+v+'" data-type="'+datDemoItems[i][0]+'"><span>'+datDemoItems[i][1]+'</span><i></i></a>' + build_list;
					};
					dat_demo_global[datDemoID] = datDemoCSS;
					if(jQuery("a[rel='ot-demo-original-panel-"+datDemoGroup+"']").size() <= 0) build_link = "<a href='#demo' rel='ot-demo-original-panel-"+datDemoGroup+"' class='option'><span>"+datDemoTitle+"</span></a>";
					jQuery('#demo-s-wrap').append(build_link+"<div class='option-box' rel='ot-demo-original-panel-"+datDemoGroup+"'><p>"+datDemoDescription+"</p><div id='ot-demo-item-id-"+globalitemid+"' alt='header-box'>"+build_list+"</div></div>");

					jQuery("#ot-demo-item-id-"+globalitemid+" [data-type]").bind("click", function () {
						var thiselem = jQuery(this),
							toggleclass = thiselem.data("data-type");
						thiselem.toggleClass("active");

						__dat_demo_js(datDemoID, toggleclass);
					});
				}else

				if(datDemoType == "select"){
					var build_list = "",build_link = "",firstch = false;
					for (var i = datDemoItems.length - 1; i >= 0; i--) {
						firstch = datDemoItems[i][0];
						var v = (i == 0)?" class='current'":"";
						build_list = '<span style="font-family: \''+datDemoItems[i][0]+'\'"'+v+'>'+datDemoItems[i][1]+'</span>' + build_list;
					};
					dat_demo_global[datDemoID] = datDemoCSS;
					if(jQuery("a[rel='ot-demo-original-panel-"+datDemoGroup+"']").size() <= 0) build_link = "<a href='#demo' rel='ot-demo-original-panel-"+datDemoGroup+"' class='option'><span>"+datDemoTitle+"</span></a>";
					jQuery('#demo-s-wrap').append(build_link+"<div class='option-box' rel='ot-demo-original-panel-"+datDemoGroup+"'><div alt='font-options'><p>"+datDemoDescription+"</p><div id='ot-demo-item-id-"+globalitemid+"' class='ot-demo-selector' data-demo-address='headers'><div class='ot-demo-selector-preview' style='font-family: \""+firstch+"\", sans-serif;'>"+datDemoSubDesc+"</div><div class='ot-demo-selector-block' data-current-font='"+firstch+"'><div class='ot-demo-selector-wrap'>"+build_list+"</div></div></div></div></div>");

					jQuery("#ot-demo-item-id-"+globalitemid).bind("click", function () {
						jQuery(this).toggleClass("active");
						jQuery(".ot-settings-reset", "body").toggle();
					});

					jQuery("#ot-demo-item-id-"+globalitemid+" .ot-demo-selector-wrap > span").bind("click", function () {
						var thiselem = jQuery(this),
							newfont = thiselem.css("font-family");
						thiselem.siblings().removeClass("current");
						thiselem.addClass("current");

						thiselem.parent().parent().attr("data-current-font", thiselem.html()).siblings(".ot-demo-selector-preview").css("font-family", newfont);

						__dat_demo_css(datDemoID, newfont);
					});
				}else

				if(datDemoType == "bulls"){
					var build_list = "",build_link = "";
					for (var i = datDemoItems.length - 1; i >= 0; i--) {
						var v = (i == 0)?" active":"";
						build_list = '<a href="#" class="color-bulb'+v+'" rel="'+datDemoItems[i][1]+'" style="'+datDemoItems[i][0]+': '+datDemoItems[i][1]+';">&nbsp;</a>' + build_list;
					};
					dat_demo_global[datDemoID] = datDemoCSS;
					if(jQuery("a[rel='ot-demo-original-panel-"+datDemoGroup+"']").size() <= 0) build_link = "<a href='#demo' rel='ot-demo-original-panel-"+datDemoGroup+"' class='option'><span>"+datDemoTitle+"</span></a>";
					jQuery('#demo-s-wrap').append(build_link+"<div class='option-box' rel='ot-demo-original-panel-"+datDemoGroup+"'><div alt='color-options'><p>"+datDemoDescription+"</p>"+build_list+"</div></div>");
					jQuery('div[rel="ot-demo-original-panel-'+datDemoGroup+'"] .color-bulb').bind("click", function () {
						var thisel = jQuery(this);
						thisel.addClass("active").siblings(".active").removeClass("active");
						__dat_demo_css(datDemoID, thisel.attr("rel"));
						return false;
					});
				}else

				if(datDemoType == "bulls-big"){
					var build_list = "",build_link = "";
					for (var i = datDemoItems.length - 1; i >= 0; i--) {
						var v = (i == 0)?" active":"";
						build_list = '<a href="#" class="color-bulb ot-big-bulb'+v+'" rel="'+datDemoItems[i][1]+'" style="'+datDemoItems[i][0]+': '+datDemoItems[i][1]+';">&nbsp;</a>' + build_list;
					};
					dat_demo_global[datDemoID] = datDemoCSS;
					if(jQuery("a[rel='ot-demo-original-panel-"+datDemoGroup+"']").size() <= 0) build_link = "<a href='#demo' rel='ot-demo-original-panel-"+datDemoGroup+"' class='option'><span>"+datDemoTitle+"</span></a>";
					jQuery('#demo-s-wrap').append(build_link+"<div class='option-box' rel='ot-demo-original-panel-"+datDemoGroup+"'><div alt='color-options'><p>"+datDemoDescription+"</p>"+build_list+"</div></div>");
					jQuery('div[rel="ot-demo-original-panel-'+datDemoGroup+'"] .color-bulb').bind("click", function () {
						var thisel = jQuery(this);
						thisel.addClass("active").siblings(".active").removeClass("active");
						__dat_demo_css(datDemoID, thisel.attr("rel"));
						return false;
					});
				}

			}else{
				return false;
			}
			return true;
		}

		__dat_demo("datcolor", 0, "Predefined Color Scheme", "", "These are just a few color presets, in reality there are unlimited color possibilities", "bulls",
			Array(["background-color", "#4f5357"], ["background-color", "#256dc1"], ["background-color", "#94be30"], ["background-color", "#6bb7e2"], ["background-color", "#e95f5f"], ["background-color", "#6856C9"], ["background-color", "#F98639"], ["background-color", "#FD77C0"]),
			Array([".main-slider .owl-nav .owl-next, .main-slider .owl-nav .owl-prev, .composs-photo-gallery-list .owl-controls .owl-nav .owl-next, .ot-w-gallery-list .owl-controls .owl-nav .owl-next, .composs-photo-gallery-list .owl-controls .owl-nav .owl-prev, .ot-w-gallery-list .owl-controls .owl-nav .owl-prev, .widget .search-form>input:hover, #main-menu, .composs-panel-pager a.composs-pager-button.active:hover", "background-color", "", false],
				["a", "color", "", false],
				["#main-menu", "border-color", "", false]));


		__dat_demo("datcolorz", 4, "Secondary color scheme", "", "These are just a few color presets, in reality there are unlimited color possibilities", "bulls",
			Array(["background-color", "#8b949d"], ["background-color", "#94be30"], ["background-color", "#4e4e4e"], ["background-color", "#6bb7e2"], ["background-color", "#e95f5f"], ["background-color", "#6856C9"], ["background-color", "#F98639"], ["background-color", "#FD77C0"]),
			Array([".composs-comments .comment-list .comment-text .user-nick .user-label, .composs-panel-buttons a, .composs-panel-buttons a.active, .composs-panel-buttons a:hover, .footer-button:hover, button, input[type=submit], .widget .tagcloud a:hover, .main-slider-owl.owl-carousel .owl-controls .owl-dot:hover:before, .main-slider-owl.owl-carousel .owl-controls .owl-dot.active:before, .widget .search-form>input, .header-top-socials>a span, .owl-carousel .owl-controls .owl-dot.active, .img-read-later-button, .composs-archive-list h3.item-title, #sidebar .widget>h3, .composs-panel-pager a.composs-pager-button.active, .composs-panel-pager a.composs-pager-button:hover, .composs-panel-pager span.page-numbers, .composs-panel>.composs-panel-title:not(.composs-panel-title-tabbed)>strong, .composs-panel>.composs-panel-title>strong.active", "background-color", "", false],
				[".comments-big-message, .composs-secondary-title>strong, .composs-panel-pager .page-numbers, .footer-button, .contact-form-content label span, .widget .tagcloud a, .main-slider-owl.owl-carousel .owl-controls .owl-dot:hover:after, .main-slider-owl.owl-carousel .owl-controls .owl-dot.active:after, .item-stars .stars-inner:before, .composs-panel>.composs-panel-title.composs-panel-title-tabbed>strong", "color", "", false],
				[".contact-form-content label textarea:focus, .contact-form-content label input:focus, .composs-panel>.composs-panel-title", "border-color", "", false],
				[".owl-carousel .owl-controls .owl-dot", "box-shadow", "inset 0 0 0 2px ", false]));


		__dat_demo("datcolorzz", 5, "Link hover color", "", "These are just a few color presets, in reality there are unlimited color possibilities", "bulls",
			Array(["background-color", "#3779bc"], ["background-color", "#94be30"], ["background-color", "#4e4e4e"], ["background-color", "#6bb7e2"], ["background-color", "#e95f5f"], ["background-color", "#6856C9"], ["background-color", "#F98639"], ["background-color", "#FD77C0"]),
			Array([".ot-shortcode-accordion>div.active>a:before, .photo-gallery-nav-left:active, .photo-gallery-nav-left:focus, .photo-gallery-nav-left, .photo-gallery-nav-right:active, .photo-gallery-nav-right:focus, .photo-gallery-nav-right", "background-color", "", false],
				["a:hover,.ot-w-comments-list .item .item-meta .item-meta-item.meta-button, .ot-shortcode-accordion>div.active>a", "color", "", false],
				[".photo-gallery-thumbs-inner .item.active:before", "box-shadow", "inset 0 0 0 3px ", false]));

		__dat_demo("datmainfont", 1, "Google Fonts (630+)", "Titles & Menu", "These are just a few fonts, in total there are 630+", "select",
			Array(["Open Sans", "Open Sans (Default)"], ["Roboto", "Roboto"], ["Lato", "Lato"], ["Source Sans Pro", "Source Sans Pro"], ["Raleway", "Raleway"], ["Playfair Display", "Playfair Display"], ["Josefin Sans", "Josefin Sans"], ["Orbitron", "Orbitron"]),
			Array(["#main-menu, h1, h2, h3, h4, h5, h6, .portus-article-slider-big .item-article-title, .article-list-full-width .item .item-title, .article-slider-full-small .item-article-title", "font-family", "", false]));

		__dat_demo("datmainfontz", 1, "Secondary Font Family", "Paragraph text", "", "select",
			Array(["Open Sans", "Open Sans (Default)"], ["Roboto", "Roboto"], ["Lato", "Lato"], ["Source Sans Pro", "Source Sans Pro"], ["Raleway", "Raleway"], ["Playfair Display", "Playfair Display"], ["Josefin Sans", "Josefin Sans"], ["Orbitron", "Orbitron"]),
			Array(["body, p", "font-family", "", false]));

		__dat_demo("choise_b", 2, "Main Settings", "", "Control whether main menu will stay on top or not.", "choise",
			Array(["boxed-layout", "Menu follow on scroll", true]),
			Array(["body", "ot-menu-will-follow"]));

		__dat_demo("choise_a", 3, "Background Textures", "", "Note: Background textures works only on boxed layout!", "choise",
			Array(["menu-follow", "Boxed Layout", false]),
			Array([".boxed", "active"]));

		__dat_demo("dattexture", 3, "", "", "You can also upload custom one", "bulls-big",
			Array(["background", "#f8f8f8"], ["background-image", "url("+dat_img_dir+"background-texture-1.jpg)"], ["background-image", "url("+dat_img_dir+"background-texture-2.jpg)"], ["background-image", "url("+dat_img_dir+"background-texture-3.jpg)"], ["background-image", "url("+dat_img_dir+"background-texture-4.jpg)"], ["background-image", "url("+dat_img_dir+"background-texture-5.jpg)"], ["background", "url("+dat_img_dir+"background-photo-1.jpg) fixed 100%"], ["background", "url("+dat_img_dir+"background-photo-2.jpg) fixed 100%"]),
			Array(["body", "background", "", true]));



		// Webfont import

		var WebFontConfig = {
			google: { families: [ 'Roboto:300,400,500,700,900:latin', 'Lato:300,400,700,900:latin', 'Source Sans Pro:400,600,700,900:latin', 'Raleway:400,600,800,700:latin', 'Playfair+Display:400,700,900:latin', 'Josefin+Sans:300,400,600,700:latin', 'Orbitron:400,700,900,500:latin' ] }
		};
		(function() {
			var wf = document.createElement('script');
			wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
				'://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
			wf.type = 'text/javascript';
			wf.async = 'true';
			var s = document.getElementsByTagName('script')[0];
			s.parentNode.insertBefore(wf, s);
		})();

	});


})(jQuery);