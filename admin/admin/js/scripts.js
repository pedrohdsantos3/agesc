(function($) {
	"use strict";
	$(document).ready(function() {
		/*==Left Navigation Accordion ==*/
		if ($.fn.dcAccordion) {
			$('#nav-accordion').dcAccordion({
				eventType: 'click',
				autoClose: true,
				saveState: true,
				disableLink: true,
				speed: 'slow',
				showCount: false,
				autoExpand: true,
				classExpand: 'dcjq-current-parent'
			});
		}
		/*==Slim Scroll ==*/
		if ($.fn.slimScroll) {
			$('.event-list').slimscroll({
				height: '305px',
				wheelStep: 20
			});
			$('.conversation-list').slimscroll({
				height: '360px',
				wheelStep: 35
			});
			$('.to-do-list').slimscroll({
				height: '300px',
				wheelStep: 35
			});
		}
		/*==Nice Scroll ==*/
		if ($.fn.niceScroll) {
			$(".leftside-navigation").niceScroll({
				cursorcolor: "#e95f5f",
				cursorborder: "0px solid #fff",
				cursorborderradius: "0px",
				cursorwidth: "3px"
			});
			$(".leftside-navigation").getNiceScroll().resize();
			if ($('#sidebar').hasClass('hide-left-bar')) {
				$(".leftside-navigation").getNiceScroll().hide();
			}
			$(".leftside-navigation").getNiceScroll().show();
			$(".right-stat-bar").niceScroll({
				cursorcolor: "#e95f5f",
				cursorborder: "0px solid #fff",
				cursorborderradius: "0px",
				cursorwidth: "3px"
			});
		}
		// /*==Easy Pie chart ==*/
		// if ($.fn.easyPieChart) {
		// 	$('.notification-pie-chart').easyPieChart({
		// 		onStep: function(from, to, percent) {
		// 			$(this.el).find('.percent').text(Math.round(percent));
		// 		},
		// 		barColor: "#39b6ac",
		// 		lineWidth: 3,
		// 		size: 50,
		// 		trackColor: "#efefef",
		// 		scaleColor: "#cccccc"
		// 	});
		// 	$('.pc-epie-chart').easyPieChart({
		// 		onStep: function(from, to, percent) {
		// 			$(this.el).find('.percent').text(Math.round(percent));
		// 		},
		// 		barColor: "#5bc6f0",
		// 		lineWidth: 3,
		// 		size: 50,
		// 		trackColor: "#32323a",
		// 		scaleColor: "#cccccc"
		// 	});
		// }
		// /*== SPARKLINE==*/
		// if ($.fn.sparkline) {
		// 	$(".d-pending").sparkline([3, 1], {
		// 		type: 'pie',
		// 		width: '40',
		// 		height: '40',
		// 		sliceColors: ['#e1e1e1', '#8175c9']
		// 	});
		// 	var sparkLine = function() {
		// 		$(".sparkline").each(function() {
		// 			var $data = $(this).data();
		// 			($data.type == 'pie') && $data.sliceColors && ($data.sliceColors = eval($data.sliceColors));
		// 			($data.type == 'bar') && $data.stackedBarColor && ($data.stackedBarColor = eval($data.stackedBarColor));
		// 			$data.valueSpots = {
		// 				'0:': $data.spotColor
		// 			};
		// 			$(this).sparkline($data.data || "html", $data);
		// 			if ($(this).data("compositeData")) {
		// 				$spdata.composite = true;
		// 				$spdata.minSpotColor = false;
		// 				$spdata.maxSpotColor = false;
		// 				$spdata.valueSpots = {
		// 					'0:': $spdata.spotColor
		// 				};
		// 				$(this).sparkline($(this).data("compositeData"), $spdata);
		// 			};
		// 		});
		// 	};
		// 	var sparkResize;
		// 	$(window).resize(function(e) {
		// 		clearTimeout(sparkResize);
		// 		sparkResize = setTimeout(function() {
		// 			sparkLine(true)
		// 		}, 500);
		// 	});
		// 	sparkLine(false);
		// }
		// if ($.fn.plot) {
		// 	var datatPie = [30, 50];
		// 	// DONUT
		// 	$.plot($(".target-sell"), datatPie, {
		// 		series: {
		// 			pie: {
		// 				innerRadius: 0.6,
		// 				show: true,
		// 				label: {
		// 					show: false
		// 				},
		// 				stroke: {
		// 					width: .01,
		// 					color: '#fff'
		// 				}
		// 			}
		// 		},
		// 		legend: {
		// 			show: true
		// 		},
		// 		grid: {
		// 			hoverable: true,
		// 			clickable: true
		// 		},
		// 		colors: ["#ff6d60", "#cbcdd9"]
		// 	});
		// }
		/*==Collapsible==*/
		$('.widget-head').click(function(e) {
			var widgetElem = $(this).children('.widget-collapse').children('i');
			$(this).next('.widget-container').slideToggle('slow');
			if ($(widgetElem).hasClass('ico-minus')) {
				$(widgetElem).removeClass('ico-minus');
				$(widgetElem).addClass('ico-plus');
			} else {
				$(widgetElem).removeClass('ico-plus');
				$(widgetElem).addClass('ico-minus');
			}
			e.preventDefault();
		});
		/*==Sidebar Toggle==*/
		$(".leftside-navigation .sub-menu > a").click(function() {
			var o = ($(this).offset());
			var diff = 60 - o.top;
			if (diff > 0) $(".leftside-navigation").scrollTo("-=" + Math.abs(diff), 500);
			else $(".leftside-navigation").scrollTo("+=" + Math.abs(diff), 500);
		});
		$('.sidebar-toggle-box .fa-bars').click(function(e) {
			$(".leftside-navigation").niceScroll({
				cursorcolor: "#e95f5f",
				cursorborder: "0px solid #fff",
				cursorborderradius: "0px",
				cursorwidth: "3px"
			});
			$('#sidebar').toggleClass('hide-left-bar');
			if ($('#sidebar').hasClass('hide-left-bar')) {
				$(".leftside-navigation").getNiceScroll().hide();
			}
			$(".leftside-navigation").getNiceScroll().show();
			$('#main-content').toggleClass('merge-left');
			e.stopPropagation();
			if ($('#container').hasClass('open-right-panel')) {
				$('#container').removeClass('open-right-panel')
			}
			if ($('.right-sidebar').hasClass('open-right-bar')) {
				$('.right-sidebar').removeClass('open-right-bar')
			}
			if ($('.header').hasClass('merge-header')) {
				$('.header').removeClass('merge-header')
			}
		});
		$('.toggle-right-box .fa-bars').click(function(e) {
			$('#container').toggleClass('open-right-panel');
			$('.right-sidebar').toggleClass('open-right-bar');
			$('.header').toggleClass('merge-header');
			e.stopPropagation();
		});
		$('.header,#main-content,#sidebar').click(function() {
			if ($('#container').hasClass('open-right-panel')) {
				$('#container').removeClass('open-right-panel')
			}
			if ($('.right-sidebar').hasClass('open-right-bar')) {
				$('.right-sidebar').removeClass('open-right-bar')
			}
			if ($('.header').hasClass('merge-header')) {
				$('.header').removeClass('merge-header')
			}
		});
		$('.panel .tools .fa').click(function() {
			var el = $(this).parents(".panel").children(".panel-body");
			if ($(this).hasClass("fa-chevron-down")) {
				$(this).removeClass("fa-chevron-down").addClass("fa-chevron-up");
				el.slideUp(200);
			} else {
				$(this).removeClass("fa-chevron-up").addClass("fa-chevron-down");
				el.slideDown(200);
			}
		});
		$('.panel .tools .fa-times').click(function() {
			$(this).parents(".panel").parent().remove();
		});
		// tool tips
		$('.tooltips').tooltip();
		// popovers
		$('.popovers').popover();

		//date picker start
		if (top.location != location) {
			top.location.href = document.location.href;
		}
		$(function() {
			window.prettyPrint && prettyPrint();
			$('.default-date-picker').datepicker({
				format: 'mm-dd-yyyy',
				autoclose: true
			});
		});

		$("#datainicio").on("dp.change", function (e) {
			$('#datafim').data("DateTimePicker").minDate(e.date);
		});
		$("#datafim").on("dp.change", function (e) {
			$('#datainicio').data("DateTimePicker").maxDate(e.date);
		});
		//date picker end

		//datetime picker start
		$(".form_datetime").datetimepicker({
			format             : 'yyyy-mm-dd hh:ii',
			language           : 'pt-BR',
			todayBtn           : 'linked',
			showTodayButton    : true,
			todayHighlight     : true,
			keyboardNavigation : true,
			autoclose          : true
		});
		//datetime picker end

		$('.mascara-cpf').mask('000.000.000-00', {placeholder: "___.___.___-__"});
		$('.mascara-cnpj').mask('00000000000000', {placeholder: "______________"});
		$('.mascara-telefone').mask('(00)0000-0000' , {placeholder: "(__)____-____"});
		$('.mascara-celular').mask('(00)00000-0000' , {placeholder: "(__)_____-____"});
		$('.mascara-data').mask('00/00/0000' , {placeholder: "__/__/____"});
		// $('.mascara-rg').mask('000000000', {placeholder: "RG"});
		$('.mascara-cep').mask('00000-000' , {placeholder: "_____-___"});
		$('.mascara-dinheiro').mask("000.000.000.000.000,00", {placeholder: "R$ 0.000,00"}, {reverse: true});

		if($("#txt").length > 0){
			CKEDITOR.replace( 'txt' );
		}

	});
})(jQuery);

var element = document.querySelector("form");
if(element.getAttribute("id") == "fNoticia" || element.getAttribute("id") == "fAgenda"){
	var destaque = document.getElementById("destaque");
	var tpost = document.getElementById("tpost");
	var thumb = document.getElementById("thumb");
	var img = document.getElementById("img");

	if(destaque){
		destaque.addEventListener("change", function(event) {
			if (destaque.checked) {
				document.getElementById("img").required = true;
			} else {
				document.getElementById("img").required = false;
			}
		});
	}

	if(tpost){
		tpost.addEventListener("change", function(event) {
			if(tpost.value == 1){
				document.getElementById("img").required = true;
			} else {
				document.getElementById("img").required = false;
			}
		});
	}

	// if(thumb){
	// 	if(thumb.currentSrc != ''){
	// 		document.getElementById("img").required = false;
	// 	}
	// }

	// if(img){
	// 	if(img.value != ''){
	// 		document.getElementById("img").required = false;
	// 	}
	// }

	element.addEventListener("submit", function(event) {
		// if(destaque.checked){
		// 	document.getElementById("img").required = true;
		// 	alert("Imagem de Capa obrigatório, pois está marcado como destaque!");
		// 	event.preventDefault();
		// } else if(tpost.value == 1 && thumb.currentSrc == '') {
		// 	document.getElementById("img").required = true;
		// 	alert("Imagem de Capa obrigatório, pois está marcado como destaque e é uma notícia!");
		// 	event.preventDefault();
		// } else {
		// 	document.getElementById("img").required = false;
		// }

		var fim = document.getElementById("datafim").value;
		if(fim){
			var inicio = document.getElementById("datainicio").value;

			if(Date.parse(inicio) > Date.parse(fim)){
				event.preventDefault();
				alert("Data Final deve ser maior que a Data Início!");
				document.getElementById("datafim").focus();
			}
		}
	});
}

function buscarEndereco(elem)
{
	var cep = Trim(elem.value);
	if(IsCEP(cep)){
		document.getElementById('rua').value = "...";
		document.getElementById('bairro').value = "...";
		document.getElementById('cidade').value = "...";
		if(document.getElementById('numero')){
			document.getElementById('numero').focus();
		} else if (document.getElementById('num')){
			document.getElementById('num').focus();
		}
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (xhttp.readyState == 4 && xhttp.status == 200) {
				var r = xhttp.response;
				street_1 = r.substring(0, (i = r.indexOf(':')));
				document.getElementById('rua').value = unescape(street_1.replace(/\+/g," "));
				r = r.substring(++i);
				street_4 = r.substring(0, (i = r.indexOf(':')));
				document.getElementById('bairro').value = unescape(street_4.replace(/\+/g," "));
				r = r.substring(++i);
				city = r.substring(0, (i = r.indexOf(':')));
				document.getElementById('cidade').value = unescape(city.replace(/\+/g," "));
				r = r.substring(++i);
				// region = r.substring(0, (i = r.indexOf(':')));
				// document.getElementById('region').selectedIndex = unescape(region.replace(/\+/g," "));
				// document.getElementById('region_id').selectedIndex = unescape(region.replace(/\+/g," "));
				// setTimeout(function() {
				// 		if(document.getElementById('numero')){
				// 			document.getElementById('numero').focus();
				// 		} else if (document.getElementById('num')){
				// 			document.getElementById('num').focus();
				// 		}
				// 	}, 1
				// );
			}
		};
		xhttp.open("GET", "buscacep.php?cep=" + cep, true);
		xhttp.send();
	}
}

function formatar(mascara, documento)
{
	var i = documento.value.length;
	var saida = mascara.substring(0,1);
	var texto = mascara.substring(i)
	if (texto.substring(0,1) != saida){
		documento.value += texto.substring(0,1);
	}
}

function Trim(strTexto)
{
	return strTexto.replace(/^s+|s+$/g, '');
}

function IsCEP(strCEP)
{
	strCEP = Trim(strCEP);

	if(strCEP.length == 8)
		var objER = /^\d{5}\d{3}$/;
	else if(strCEP.length == 9)
		var objER = /^\d{5}-\d{3}$/;
	else
		return false;

	if(objER.test(strCEP))
		return true;
	else
		return false;
}

function removeLastTr(id,elem)
{
	var $table = jQuery('#input_fields tbody');
	var $tr = $table.find('tr');
	if( $tr.length >= 2 ){
		if ( confirm("Deseja realmente excluir esse Dependente?")) {
			if( id > 0 ){
				var xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function() {
					if (xhttp.readyState == 4 && xhttp.status == 200) {
						elem.parentElement.parentElement.remove();
					}
				};
				xhttp.open("GET", "excluir_dependente.php?id="+id, true);
				xhttp.send();
			} else {
				elem.parentElement.parentElement.remove();
			}
		}
	}
}
