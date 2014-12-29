var BASE_URL = 'http://127.0.0.1/fit4you/';

function load_ckeditor(id) {


	
	CKEDITOR.replace(id, {
		
		toolbar: 'Full'
	
	});
	
	
	
	var editor = CKEDITOR.instances[id];
	editor.config.extraPlugins = 'justify';
	
	editor.ui.addButton('remove_text', {
		label: 'Usuń to pole tekstowe',
		command: 'remove_text',
		icon: 'ico_remove.png'
	});
	
	editor.addCommand( 'remove_text', {
		exec : function( editor ) {
			
			$.ajax({
				url: BASE_URL + 'admin/page/remove_element/' + editor.name + '/text',
				type: 'POST',
				dataType: 'json',
				data: {ajax:true},
				timeout: 2000,
				beforeSend  : function() {
					$('#preloader').show();
				},
				success: function(result) {	
					$('#preloader').hide();	
	
					$('#' + result.id).remove();
					editor.destroy();
	
				}
			});
			
	
		}
	});
	
}; 


function load_uploadify(id, type) {

    $("#" + type + "_upload_" + id).uploadify({
		formData      : {"id" : id},
        height        : 30,
		buttonText	  : 'Przeglądaj',
        swf           : BASE_URL + 'js/uploadify/uploadify.swf',
		cancelImg	  : BASE_URL + 'js/uploadify/uploadify-cancel.png',
        uploader      : BASE_URL + 'admin/page/' + type + '_upload',
        width         : 102,
		auto          : true,
		'onUploadSuccess' : function(file, data, response) {
			
			$("#gallery_" + id + "_photos").append(data)
			console.log("#gallery_" + id + "_photos");
			
		}
    });
	
}; 


$.fn.checkEmail = function() {
		
	var field = $(this);
	var email = field.val();
	var except = field.data('except');
	status;

	if(field.data('unique') == true) {
	
		if(email) {
			$.ajax({
				url: BASE_URL + 'user/email_exists/' + ((email)?$.base64.encode(email):'') + '/' + ((except)?$.base64.encode(except):''),
				type: 'POST',
				dataType: 'json',
				data: { email : email, ajax: true  },
				success: function(result) {
		
					if(result == 'EXIST') {
	
						field.parent().removeClass('has-success');
						field.parent().addClass('has-error');
						$('#email_exists_text_helper').remove();
						field.after('<span class="help-block" id="email_exists_text_helper">Ten email już znajduje się w naszej bazie, <a href="'+ BASE_URL + 'user/login/' + $.base64.encode(window.location.pathname) + '">zaloguj się</a>.</span>');
						status = false;
						
					} else if(result == 'NOT_FOUND') {
	
						field.parent().removeClass('has-error');
						field.parent().addClass('has-success');
						$('#email_exists_text_helper').remove();
						field.after('<span class="help-block" id="email_exists_text_helper">Email jest poprawny.</span>');
						status = true;
						
					}
				
				}
			});	
		} else {
			field.parent().removeClass("has-error has-success");
			$('#email_exists_text_helper').remove();
		}

	}
	
	return status;

};


$(document).ready(function() { 

	/*-----------------------------------------------------------------------
	|
	|
							PAGE
	|
	|
	-----------------------------------------------------------------------*/
	
		//LOGIN MENU
		$('#user_menu .dropdown-menu textarea, #user_menu .dropdown-menu input, #user_menu .dropdown-menu label').click(function(e) {
			e.stopPropagation();
		});
	
		//LAZY LOAD IMAGES
		$("img.lazy").show().lazyload({
			effect : "fadeIn",
			appear : function(elements_left, settings) {
				$(this).css( {'width' : '24px',  'display' : 'block' } );
			},
			load : function(elements_left, settings) {
				$(this).css( {'width' : $(this).data('width'), 'padding' : '' } );
				$('.elements img.lazy').css( {'display' : 'inline' } );
			}
		});

		$('body').on('show.bs.modal', '.modal', function () {
	
			$('.modal').not(this).modal('hide');
			
		})
		
		$('body').on('mouseenter', '.tooltipa', function() {
			$(this).tooltip({'html' : true});
			$(this).tooltip('show');
		});
		
		$('.popovera').popover({'html' : true, 'trigger' : 'hover focus', container: 'body'});
		$('.popovera_click').popover({'html' : true});
		$('.popovera_login').popover({'html' : true});
		$('#pricing').collapse()
		$('#pricing').on('show.bs.collapse', function () {
			
			$('#pricing .in').collapse('hide');
		
			//alert($('#pricing').offset().top);
			$("html, body").delay(100).animate({scrollTop: $('#pricing').offset().top }, 2000);
			
		});
		
		//sprawdzanie emaila
		$('body').on('focus, blur', 'input[name=email]', function() {
			$(this).checkEmail();	
		});


		//DROPDOWN
		$('li.dropdown').hover(function() {
			$(this).find('.dropdown-menu').stop(true, true).show();
			
		}, function() {
			$(this).find('.dropdown-menu').stop(true, true).hide();
		
		});
		
		$('.accordion').collapse({
			toggle: false
		})



	/*-----------------------------------------------------------------------
	|
	|
							ADMIN
	|
	|
	-----------------------------------------------------------------------*/
	
		if($('#div_food_form').length != 0) {
			var pos = $('#div_food_form').offset();
			$('#div_food_form').css({'width' : $('#div_food_form').parent().width() + 'px', 'top' : '20px', 'height' : $( window ).height() - pos.top - 30});
			setTimeout(function () {
				var pos = $('#div_food_form').offset();
				$('#div_food_form').affix({
					offset: {
						top: function() {
							return pos.top - 20;	
						}
					}
				})
			}, 100);
		}

		//EDITOR
		$("#editor_form .ckeditor").each(function( index ) {
			var id = $(this).attr('id');
			load_ckeditor(id);
		});
		$("#editor_form .uploadify").each(function( index ) {
			
			var id = $(this).data('id');
			var type = $(this).data('type');
			load_uploadify(id, type);
	
		});
		
		//ADD ELEMENT
		$('body').on('click', ".btn_add_element", function() {
			
			var module = $(this).data('module');
			var module_id = $(this).data('module_id');
			var type = $(this).data('type');
			
			$.ajax({
				url: BASE_URL + 'admin/page/add_element_box',
				type: 'POST',
				dataType: 'json',
				data: {type:type, module:module, module_id:module_id},
				timeout: 2000,
				beforeSend  : function() {
					$('#preloader').show();
				},
				success: function(result) {	
					$('#preloader').hide();	
				
					$("#elements").append(result.data);
					if(type == 'text') {
						load_ckeditor("text_" + result.element_id);
					} else if(type == 'gallery' || type == 'folder') {
						load_uploadify(result.id, type);	
					}
				}
			});
		});
		
		//REMOVE
		$('body').on('click', ".btn_remove_element", function() {
			
			var id = $(this).data('id');
			var type = $(this).data('type');
			
			$.ajax({
				url: BASE_URL + 'admin/page/remove_element/' + id + '/' + type,
				type: 'POST',
				dataType: 'json',
				data: {ajax:true},
				timeout: 2000,
				beforeSend  : function() {
					$('#preloader').show();
				},
				success: function(result) {	
					$('#preloader').hide();	
	
					$('#' + type + '_' + id).remove();
	
				}
			});
			
		});
		
		

			
		//SAVE
		$("body").on('click', '.btn_save_editor', function() {  
	
			var module = $('input[name=module]').val();
			var module_id = $('input[name=module_id]').val();
	
			//FORM FIELDS
			form_obj = new Object();
			$('.ajax_save').each( function(i) {
				if($(this).attr('type') == 'radio' || $(this).attr('type') == 'checkbox') {
					if($(this).is(':checked')) {
						form_obj[$(this).attr('name')] = $(this).val();	
					} else {
						if(!form_obj[$(this).attr('name')]) {
							form_obj[$(this).attr('name')] = 0;	
						}
					}
				} else {
					form_obj[$(this).attr('name')] = $(this).val();
				}
			});
			console.log(form_obj);
			
			
			//TEXTS
			var inst_text, text_obj = new Object();
			for (name in CKEDITOR.instances) {
				
				text_obj[name] = CKEDITOR.instances[name].getData();
				
			}
			console.log(text_obj);
	
			
			/*
			//videos
			var j, video_id, video_obj = new Object();
			j = 0;
			$('.video_box input').each(function() {
				video_id = $(this).data('video_id');
	
				video_array = new Array(3);
				video_array[0] =  $(this).val() ;
				video_array[1] =  $('#video_textarea_' + video_id).val() ;
				video_array[2] =  video_id ;
	
				video_obj[j] = video_array;
				j = j + 1;
			});
			console.log(video_obj);
			
			//quotes
			var i, quote_id, quote_obj = new Object();
			i = 0;
			$('.quote_box input').each(function() {
				quote_id = $(this).data('quote_id');
				
				quote_array = new Array(3);
				quote_array[0] =  $(this).val() ;
				quote_array[1] =  $('#quote_textarea_' + quote_id).val() ;
				quote_array[2] =  quote_id ;
	
				quote_obj[i] = quote_array;
				i = i + 1;
			});
			console.log(quote_obj);
			*/
			
			$.ajax({  
				type: "POST",  
				url: BASE_URL + "admin/page/save_editor",  
				data: {	module:module,
						module_id:module_id,
						
						form_obj:form_obj,
						text_obj:text_obj
		
						},  
						
				beforeSend  : function() {
					$('#preloader').show();
				},
				success: function(data) {	
					$('#preloader').hide();	
					
					
					if(module_id != 0) {
						
						$('#message').removeClass('hide').fadeIn(1500, function() {  
							
						});
						$('html, body').animate({scrollTop: $('#message').offset().top - 20}, 'slow');
						setTimeout(function() {
							$("#message").hide('blind', {}, 500)
						}, 5000);
						
					} else {
						
						window.location = BASE_URL + 'admin/'+module+'/edit/' + data;
						
					}
					
				}  
			});  
			return false;  
		}); 
	

		
		

	//EDIT FIELD
		$('body').on('click', ".btn_update_field", function() {
			
			var table = $(this).data('table');
			var field = $(this).data('field');
			var value = $(	$(this).data('value')	).val();
			var id = $(this).data('id');
			
			$.ajax({
				url: BASE_URL + 'admin/page/update_field',
				type: 'POST',
				dataType: 'html',
				data: {table:table, field:field, value:value, id:id},
				timeout: 2000,
				beforeSend  : function() {
					$('#preloader').show();
				},
				success: function(result) {	
				
					$('#preloader').hide();	
					
				}
			});
		});
	
		
		
	$("body").on('click', '.btn_copy_grammage', function() {  
		$(".input_grammage").each(function() {
			var meal = $(this).data('meal');
			var type = $(this).data('type');
			$(this).val(	$('#pattern_' + meal + '_' + type).val() 	);
		});

	});
	$("body").on('click', '.btn_copy_notice', function() {  
		$(".textarea_notice").each(function() {
			$(this).val(	$('#pattern_notice').val()	 );
		});

	}); 
	
	$("body").on('click', '.btn_copy_keyword', function() {  
		$(".textarea_keyword").each(function() {
			$(this).val(	$('#pattern_keyword').val()	 );
		});
	});
	
	$("body").on('click', '.btn_copy_price', function() {  
		$(".textarea_price").each(function() {
			$(this).val(	$('#pattern_price').val()	 );
		});
	});
	
	$("body").on('click', '.btn_submit_grammage_form', function() {  
		$("#grammage_form").submit();

	});
	
	$("body").on('click', '.btn_copy_delivery', function() {  
		$(".input_delivery").each(function() {
			var name = $(this).data('name');
			$(this).val(	$('#pattern_' + name).val() 	);
		});

	});
	
	//MODAL UNIWERSAL
	$('body').on('click', '.btn_modal', function () {
		
		var id = $(this).data('id');
		var cont = $(this).data('cont');
		var func = $(this).data('func');
		
		$.ajax({
			url: BASE_URL + 'admin/' + cont + '/' + func + '/' + id,
			type: 'POST',
			dataType: 'html',
			data: {  },
			beforeSend  : function() {
				$('#preloader').show();	
				console.log('ladowanie');
			},
			success: function(result) {	
			
				$('#preloader').hide();	
				
				$('#div_' + cont + '_' + func).html(result);
				$('#modal_' + cont + '_' + func + '_' + id).modal('show');
				
				if($('#user_message').lenght != 0) {
					load_ckeditor('user_message');
				}
			}
		});	
		
	}); 
	
	
	$('body').on('click', '.btn_delivery_like_invoice', function () {
		
		$('#order_form input[name=delivery_name_surname]').val($('#order_form input[name=name_surname]').val());
		$('#order_form input[name=delivery_city]').val($('#order_form input[name=city]').val());
		$('#order_form input[name=delivery_postcode]').val($('#order_form input[name=postcode]').val());
		$('#order_form input[name=delivery_phone]').val($('#order_form input[name=phone]').val());
		$('#order_form input[name=delivery_address]').val($('#order_form input[name=address]').val());
		
	}); 

	var hash = window.location.hash.substring(1);
	$('#' + hash).css({'border' : '5px solid #def0d8'});
	
	



	$('body').on('click', '.btn_set_checkbox', function() {
	
		var selector = $(this).data('selector');
		var value = $(this).data('value');
		
		$(selector).prop('checked', value);
		
	});


	jsPlumb.bind("ready", function() {
		
		var common = {
			endpoint: ["Dot", {
				radius: 1
			}],
			endpointStyle: {
				fillStyle: "#d8544f"
			},
			paintStyle: {
				strokeStyle: "#d8544f",
				lineWidth: 1
			},
			connector:[ "StateMachine", { curviness: -20 } ],
			connectorStyle: {
				lineWidth: 1,
				strokeStyle: "#d8544f"
			},
			overlays: [
				["Arrow", {
					width: 10,
					length: 10,
					foldback: 1,
					location: 1,
					id: "arrow"
				}]
			],
			anchor: [ "Perimeter", { shape:"Circle" } ]
		};
		
		jsPlumb.Defaults.Container = $("#plumb");
		
		$('.delivery_calendar .moved').each(function() {
			if ($('#' + $(this).attr('id')).length > 0 && $('#' + $(this).data('moved')).length > 0) {
				jsPlumb.connect({ source: $(this).attr('id'), target: $(this).data('moved') }, common);	
			}
		});
		
		/*
		jsPlumb.Defaults.Container = $("#plumb");
		jsPlumb.connect({ 
			source: 'delivery_2013-12-20',
			target: 'delivery_2013-12-30',
			endpoint: ["Dot", {
				radius: 1
			}],
			endpointStyle: {
				fillStyle: "#d8544f"
			},
			paintStyle: {
				strokeStyle: "#d8544f",
				lineWidth: 1
			},
			connector:[ "StateMachine", { curviness: -20 } ],
			connectorStyle: {
				lineWidth: 1,
				strokeStyle: "#d8544f"
			},
			overlays: [
				["Arrow", {
					width: 10,
					length: 10,
					foldback: 1,
					location: 1,
					id: "arrow"
				}]
			],
			anchor: [ "Perimeter", { shape:"Circle" } ]
		});
		/**/
	});
	
	
	
	$('body').on('click', '.btn_download_grammage_delivery', function() {
	
		var date = $(this).data('date');
		$('#delivery_download_date').val(date);
		
	});
	
	if(		$('#promotion').length > 0		) {
		$('#promotion_modal').modal('show');
	}
	
	
	$('body').on('click', '.confirm', function(event) {

		event.preventDefault();
		var href = $(this).attr('href');
        $(this).popover({
		
			placement: 'left',
			html: true,
			title: 'Czy jesteś pewien?',
			content: '<div class="btn-group"><a href="'+href+'" class="btn btn-success">TAK</a> <button type="button" class="btn btn-danger confirm_close">NIE</button></div>'
			
		}).popover('show');
		
	});
	$('body').on('click', '.confirm_close', function(event) {

		$('.confirm').popover('destroy');
		
	});
	
	

	/*-----------------------------------------------------------------------
	|
	|
							CONSULTATION
	|
	|
	-----------------------------------------------------------------------*/

	$('#consultation_offer_carousel').carousel({'interval' : false});
	$('#delivery_calendar_carousel').carousel({'interval' : false});
	$('#delivery_calendar_carousel .delivery_calendar .today').parent().css({'background' : '#eeeeee'});
	$('body').on('click', '#btn_consultation_next', function() {
		
		var products = [];
		$("#consultation_form .product").each(function( index ) {
			
			if ($(this).is(':checked')) {
				products.push($(this).attr('id'));
			}
			
	
		});
		
		$.ajax({
			url: '/consultation/summary',
			type: 'POST',
			dataType: 'html',
			data: { products : products  },
			beforeSend  : function() {
				$('#preloader').show();
			},
			success: function(result) {	
				$('#preloader').hide();	

				$('#div_summary').html(result);
				$('#consultation_offer_carousel').carousel('next');
				$("html, body").delay(100).animate({scrollTop: $('#welcome_back_text').offset().top }, 2000);
				
				$('input[name=email]').blur();
		
			}
		});	
		
	});
	
	$('body').on('click', '#btn_consultation_prev', function() {
		
		$('#consultation_offer_carousel').carousel('prev');
		$("html, body").delay(100).animate({scrollTop: $('#welcome_back_text').offset().top }, 2000);
		
	});
	
	$('body').on('click', '#btn_consultation_buy', function() {

		var status = $("#consultation_email").checkEmail();
		console.log(status);
		
		if(status == "true") {
			//
		} else {
			return false;	
		}
		
	});
	
	
	
	
	
	
	

	//SKŁADANIE ZAMÓWIENIA
	$('body').on('focus', '.dp', function () {
		$('.dp').datetimepicker({
			format: 'yyyy-mm-dd',
			minView: 2,
			startView: 3,
			todayBtn: true,
			language: 'pl'
		});
	});
	$('body').on('focus', '.dtp', function () {
		$('.dtp').datetimepicker({
			format: 'yyyy-mm-dd hh:ii:ss',
			minView: 0,
			startView: 3,
			todayBtn: true,
			language: "pl"
		});
	});
	
	$('body').on('focus', '#delivery_start_date', function () {
		
		var start_date = $(this).data('start_date');

		$('#delivery_start_date').datetimepicker({
			format: 'yyyy-mm-dd',
			minView: 2,
			startView: 3,
			language: "pl"
		}).datetimepicker('setStartDate', start_date).datetimepicker('update', new Date(start_date));
		
	});
	
	$('.dr').daterangepicker({
			format: 'YYYY-MM-DD',
			opens: 'left',
			separator: ' do ',
			ranges: {
				//'Wczoraj': [moment().subtract('days', 1), moment().subtract('days', 1)],
				//'Dziś': [moment(), moment()],
				'Najbliższe 3 dni': [moment(), moment().add('days', 2)],
				'Najbliższe 7 dni': [moment(), moment().add('days', 6)],
				'Najbliższe 2 tygodnie': [moment(), moment().add('days', 13)],
			},
			startDate: moment(),
			endDate: moment().add('days', 2),
			locale: {
				applyLabel: "Zapisz",
				cancelLabel: "Anuluj",
				fromLabel: "Od",
				toLabel: "Do",
				firstDay: 1,
				customRangeLabel: 'Wybierz przedział',
				daysOfWeek: ['Nie', 'Pon', 'Wt', 'Śr', 'Cz', 'Pią', 'Sob'],
				monthNames: ['Styczeń', 'Luty', 'Marzec', 'Kwiecień', 'Maj', 'Czerwiec', 'Lipiec', 'Sierpień', 'Wrzesień', 'Październik', 'Listopad', 'Grudzień'],
			},	
		},
		function(start, end) {
			
			console.log('chuj');
			var meals_per_day = $('#product option:selected').data('price_per_day');
			var difference = new Date(end.format('YYYY-MM-DD')) - new Date(start.format('YYYY-MM-DD'));
			var days = parseInt(	(difference/(3600*1000*24))	)+1	;
			
			$('#delivery_range_days').val(days);
			$('#delivery_range_start').val(start.format('YYYY-MM-DD'));
			$('#delivery_range_end').val(end.format('YYYY-MM-DD'));
			
			

		}
	);
	
	//ZAMOWIENIE W ADMINIE
	//PODSUMOWANIE
	$('body').on('change', '.delivery_mode, #delivery_product, #delivery_range, #delivery_start, #delivery_days, .delivery_day', function () {

		var mode = $('input.delivery_mode:checked').val()
		var selected_days = new Array();
		var days = 0;
		
		if(mode == 'days') {
			
			var days_count = parseInt($('#delivery_days').val());

			var t = ($('#delivery_start').val()).split('-');
			t[1] = t[1]-1;
			var start_date = new Date(t[0], t[1], t[2]);

		} else if(mode == 'range') {
			
			var days_count = $('#delivery_range_days').val();

			var t = ($('#delivery_range_start').val()).split('-');
			t[1] = t[1]-1;
			var start_date = new Date(t[0], t[1], t[2]);

		}
		
		if(mode == 'days' || mode == 'range') {
			
			//wybrane dni
			$('.delivery_day').each( function() {
				if(this.checked) {
					selected_days.push(		$(this).val()-1	);	
				}
				
			});
			
			console.clear();
			console.log(selected_days);
			console.log(start_date);
			
			for (var i = 0; i < days_count; i++) {	
				//inc
				if(i != 0) {
					start_date.setDate(start_date.getDate()+1);
				}
				//check
				console.log(start_date.getDay());
				if(selected_days.indexOf(start_date.getDay()) > -1) {
					days++;
				}
			}
			
			console.log(start_date);
			console.log(days);
			
			var price_per_day = $('#delivery_product option:selected').data('price_per_day');	
			if(days && price_per_day)
				$('#delivery_summary').html('Wybrałeś ' + days + ' dni dostaw za łączną kwotę ' + price_per_day*days + ' zł');
			
		}

	
	});
	
	//WYBOR TRYBU
	$('body').on('change', '.delivery_mode', function () {
	
		var value = $(this).data('value');
		
		if(value == 'range') {
			$('#delivery_mode_days').addClass('hide');
			$('#delivery_mode_calendar').addClass('hide');
			$('#delivery_mode_range').removeClass('hide');
			$('#div_delivery_day').removeClass('hide');
		} else if(value == 'calendar') {
			$('#delivery_mode_days').addClass('hide');
			$('#delivery_mode_calendar').removeClass('hide');
			$('#delivery_mode_range').addClass('hide');
			$('#div_delivery_day').addClass('hide');
		} else {
			$('#delivery_mode_days').removeClass('hide');
			$('#delivery_mode_calendar').addClass('hide');
			$('#delivery_mode_range').addClass('hide');
			$('#div_delivery_day').removeClass('hide');
		}
		
		$('#delivery_summary').html('Wybierz powyższe opcje dostawy, aby zobaczyć podsumowanie.');
	
	});
	
	//WYBÓR DNI
	selected = new Array();
	function update_summary() {
		
		//usuwam nulle wybrane
		var count = 0;
		selected.forEach(function(day) {
			if(day != null) {
				count++;
			}
		});
		var price_per_day = $('#delivery_product option:selected').data('price_per_day');
		
		if(count && price_per_day)
			$('#delivery_summary').html('Wybrałeś ' + count + ' dni dostaw za łączną kwotę ' + price_per_day * count + ' zł' );
		
	}
	
	//DODANIE DNIA
	$('body').on('click', '#delivery_mode_calendar .free', function () {
	
		$(this).removeClass('free');
		$(this).addClass('busy label label-primary');
		
		//dodaje inputa
		$('#delivery_mode_calendar_days').append('<input type="hidden" name="delivery_mode_calendar_day[]" id="delivery_mode_calendar_day_' + $(this).data('date') + '" value="' + $(this).data('date') + '" />');
		
		selected.push(	$(this).data('date')  );
		update_summary();
		//console.log(selected);
	
	});
	
	//REZYGNACJA Z DNIA
	$('body').on('click', '#delivery_mode_calendar .busy', function () {
		
		$(this).removeClass('busy label label-primary');
		$(this).addClass('free');
		
		//usuwam inputa
		$('#delivery_mode_calendar_days #delivery_mode_calendar_day_' + $(this).data('date')).remove();
		
		selected[selected.indexOf(	$(this).data('date')	)] = null;
		update_summary();
		//console.log(selected);

	});
	
	//WYBOR PRODUKTU TYLKO dla kalaendarza
	$('body').on('change', '#delivery_product', function () {
		
		//usuwam nulle wybrane
		var value = $('input.delivery_mode:checked').val();
		
		if(value == 'calendar') {
			var count = 0;
			selected.forEach(function(day) {
				if(day != null) {
					count++;
				}
			});
			var price_per_day = $('#delivery_product option:selected').data('price_per_day');
			
			if(count && price_per_day)
				$('#delivery_summary').html('Wybrałeś ' + count + ' dni dostaw za łączną kwotę ' + price_per_day*count + ' zł');
				
		}
		
	});
		
	function load_calendar(date) {
			
		if($('#delivery_mode_calendar_').length != 0) {
			
			var d = date.split('-');
			//console.log(d);
			var date = new Date(d[0], d[1], d[2]);
			//console.log(date);
			var date_prev = new Date(date.setMonth(date.getMonth() - 1));
			//console.log(date_prev);
			var date_next = new Date(date.setMonth(date.getMonth() + 2));
			//console.log(date_next);
			
			var user_id = $('#delivery_mode_calendar_').data('user_id');
			
			$.ajax({
				url: BASE_URL + 'admin/delivery/calendar/' + date.getFullYear() + '-' + date.getMonth() + '-' + date.getDate() + '/' + user_id,
				type: 'POST',
				dataType: 'html',
				data: {  },
				beforeSend  : function() {
					$('#preloader').show();
				},
				success: function(result) {	
				
					$('#preloader').hide();	
		
					$('#delivery_mode_calendar #delivery_mode_calendar_').html(result);
					$('#delivery_mode_calendar .prev').data('date', date_prev.getFullYear() + '-' + date_prev.getMonth() + '-' + date_prev.getDate());
					$('#delivery_mode_calendar .next').data('date', date_next.getFullYear() + '-' + date_next.getMonth() + '-' + date_next.getDate());
					
					//zaznaczanie dni
					
					//aktualizauje
					selected.forEach(function(day) {
						$('#delivery_calendar_day_' + day).removeClass('free');
						$('#delivery_calendar_day_' + day).addClass('busy label label-primary');
					});	
					
				}
			});	
		
		}
	}
	
	var dcd = new Date();
	load_calendar(dcd.getFullYear() + '-' + dcd.getMonth() + '-' + dcd.getDate());
	
	$('body').on('click', '#delivery_mode_calendar .prev, #delivery_mode_calendar .next', function () {
		
		var date = $(this).data('date');
		load_calendar(date);
		
	});
	

	
	
	
	
	/**/
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	$('body').on('change', '#select_meals_per_day, #select_days', function () {


		if($(this).attr('id') == 'select_meals_per_day') {
			
			var meals_per_day = $('#select_meals_per_day').val();
			var days = null;
			var meals_selected = [];
			
			//set
			var meals = $('#select_meals_per_day').find(':selected').data('meals');
			$("#delivery_selected_meals").data( "limit",  meals);
			
		} else if($(this).attr('id') == 'select_days') {
			
			var meals_per_day = $('#select_meals_per_day').val();
			var days = $('#select_days').val();
			var meals_selected = [];
			$(".delivery_meal").each(function() {
				if(this.checked) {
					meals_selected.push($(this).val());
				}
			});
			
		}
		
		$.ajax({
			url: BASE_URL + 'page/order/change_packet/' + meals_per_day + '/' + days,
			type: 'POST',
			dataType: 'json',
			data: { meals_selected : meals_selected },
			beforeSend  : function() {
				$('#preloader').show();
			},
			success: function(result) {	
				$('#preloader').hide();	
				
				if(days) {

					$('#text_price').html('<span style="font-size: 18px;color: #ccc">' + result.days + ' dni x ' + result.price_for_day  + ' PLN/dzień =</span> <span class="label label-danger"> ' + result.price + ' PLN </span>').removeClass('hide');
					$('#btn_order').removeClass('hide');
					$('#delivery_start_date').parent().removeClass('hide');
						
				} else {
					
					//$('#delivery_selected_meals').addClass('hide');
				
					//$('#div_select_days').find('option').remove().end();
					//$('#div_select_days').append(jQuery("<option></option>").attr("value", '').text(" -- wybierz -- "));
					
					$('#div_select_days option[value=""]').prop('selected', true);
					$('#div_select_days').addClass('hide');	
					
					$('#delivery_selected_meals').removeClass('hide');
					$(".delivery_meal").each(function() {
						
						$(this).prop('checked', false);
						$(this).parent().removeClass('active');

					});
					
					$('#text_price').addClass('hide');
					$('#delivery_start_date').parent().addClass('hide');
					$('#btn_order').addClass('hide');
					
				} 
				
			}
		});	
		
	});
	
	$('body').on('change', '#delivery_selected_meals input', function () {
		var count = 0;
		var limit = $('#delivery_selected_meals').data('limit');
		$.each($('#delivery_selected_meals input'), function () {
			if(this.checked) {
				count++;		
			}
		});
		console.log(count);
		
		
		if(count == limit) {
			$('#div_select_days option[value=""]').prop('selected', true);
			$('#div_select_days').removeClass('hide');		
		} else {
			
			$('#div_select_days option[value=""]').prop('selected', true);
			$('#div_select_days').addClass('hide');	
			
			$('#text_price').addClass('hide');
			$('#delivery_start_date').parent().addClass('hide');
			$('#btn_order').addClass('hide');
			
		}
		
	});
	
	

	//PANEL
	$('body').on('click', '.delivery_index .btn_delivery_day', function () {
		
		var date = $(this).data('date');
		var pay = $(this).data('pay');
		var url = BASE_URL + 'cp/delivery/read/' + date + ((pay == true)?'/' + pay:''); 
		
		show_delivery_day_modal(url, false, date);
		
	});
	//Panel sprzedawcy
	$('body').on('click', '.summary_index .btn_delivery_day, .user_details .btn_delivery_day', function () {
		
		var date = $(this).data('date');
		var pay = $(this).data('pay');
		var user_id = $('#current_client_id').val();
		var url = BASE_URL + 'sp/summary/read/' + date + ((pay == true)?'/' + pay:''); 
		var controler = $('#controler').val();
		
		show_delivery_day_modal(url, user_id, date, controler);
		
	});
	
	function show_delivery_day_modal(url, user_id, date, controler) {
	
		$.ajax({
			url: url,
			type: 'POST',
			dataType: 'html',
			data: { user_id: user_id, controler:controler  },
			beforeSend  : function() {
				$('#preloader').show();
			},
			success: function(result) {	
				$('#preloader').hide();	
				
				$('#div_delivery').html(result);
				$('#modal_delivery_' + date).modal('show');
			
			}
		});		
		
	}
	
	
	$('body').on('click', '.btn_order_modal_details', function () {
		
		var invalid = false;
		var status = $("#order_email").checkEmail();

		$(".invoice_data input.form-control").each(function( index ) {
			//console.log($(this)[0]);
			if($(this).val() == "" || status != "true") {
				invalid = true;
				$('#btn_make_order').click(); 
				return false;
			}
		});
		
		if(invalid == true) {
			return false;
		}
	
	});
	
	$('body').on('click', '.btn_order_modal_interview', function () {
		
		var invalid = false;
		
		//dane dostawy
		$(".delivery_data input.form-control").each(function( index ) {
			//if(!$(this)[0].checkValidity()) {
			if($(this).val() == "") {
				invalid = true;
				$('#btn_make_order').click(); 
				return false;
			}
		});
		
		//godzina dostawy
		if($('.details_data select[name="delivery_hours"]').val() == "") {
	
			invalid = true;
			$('#btn_make_order').click(); 
			return false;
		}
			
		if(invalid == true) {
			return false;
		}
	});
	
	
	
	
	/*
	
	
	//KALENDARZ
	
	total_days = parseInt($('#total_days').html());
	
	//TWORZENIE KALENDARZA
	$('body').on('click', '.btn_order_modal_details', function () {

		$(".order_calendar .day").each(function( index ) {
			
			if(index < total_days) {
				
				if(true) {
					
					$(this).addClass('avalible label label-default');
					
					if($(this).data('dayname') < 5) {
						$(this).removeClass('avalible label-default');
						$(this).addClass('busy label-primary');
					}
				
				}
				
			}

		});
		
	});
	
	//WYBÓR DNIA
	$('body').on('click', '.order_calendar .day.avalible', function () {
		
		var left_days = parseInt($('#left_days').html());

		if(left_days > 0) {
			$('#left_days').html(	left_days - 1	);
	
			$(this).removeClass('avalible label-default');
			$(this).addClass('busy label-primary');
		}
		
	});
	
	//REZYGNACJA Z DNIA
	$('body').on('click', '.order_calendar .day.busy', function () {
		
		var left_days = parseInt($('#left_days').html());

		$('#left_days').html(	left_days + 1	);

		$(this).removeClass('busy label-primary');
		$(this).addClass('avalible label-default');

		
	});
	
	
	//*/
	
	
	
});
