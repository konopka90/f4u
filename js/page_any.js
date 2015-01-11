$(document).ready(function() { 

	//KALENDARZ SKŁADANIA ZAMOWIENIA PRZEZ UZYTKOWNIKA
	mode = false;
	days_selected = new Array();
	product_id = false;
	diet = false;
	sex = false;


	/*-----------------------------------------------------
	/
	/		OFERTA
	/
	-----------------------------------------------------*/
	
	//WYBÓR DIETY
	$('body').on('change', '.input_select_diet', function() {
		
		var name = $(this).data('name');
		
		if(!this.checked) {
			$('.input_select_diet').each(function() {

				diet = false;
				$('#div_diet_' + $(this).data('name')	).slideDown().removeClass('active');
				$('#input_diet').val(diet);
				
				
			});
			
		} else {
			
			$('.input_select_diet').each(function() {
				
				name_loop = $(this).data('name');

				if(name != name_loop) {
					$('#div_diet_' + name_loop).slideUp().removeClass('active');
				} else {
					diet = name_loop;
					$('#div_diet_' + diet).slideDown().addClass('active');
					$('#input_diet').val(diet);
				}

			});
			
			if(mode) {
				div_range_days_calendar_mode_show_hide();
			}
			
			update_summary();
			
		}
		
		
	});
	
	//Zmiana kalorii
	$('body').on('change', '#diet_kaloryczna_calories', function () {

		update_summary();

	});

	//WYBÓR PŁCI
	$('.select_sex').button();
	$('body').on('change', '.select_sex', function () {

		//TRYB
		$(this).prop('checked', true);
		sex = $(this).val();
		$('#input_sex').val(sex);
		
		update_summary();

	});



	/*-----------------------------------------------------
	/
	/		TRYBY i WYŚWIETLANIE
	/
	-----------------------------------------------------*/
	$('body').on('change', '#div_select_mode .select_mode', function () {
		
		
		//TRYB
		mode = $('#div_select_mode input.select_mode:checked').val();
		$('#input_select_mode').val(mode);
		
		//WYCZYSC WSZYSTKO
		days_selected = new Array();
		product_id = false;
		$('#delivery_range').val('');
		$('#delivery_range_days').val('');
		$('#delivery_range_start').val('');
		$('#delivery_range_end').val('');
		$('#delivery_days_start').val('');
		$('#delivery_count_days').val('');
		
		$('#div_order_delivery_days').html('');
		$('#div_btn_order').hide();
		$('#delivery_summary').html('');
		
		//POKAZ CO TRZEBA
		$('.div_mode').hide();
		$('#div_' + mode + '_mode').show();
		if(mode == 'range' || mode == 'days') {
			

			$('#div_range_days_mode').show();
			
			days_selected_recalculate_days(mode);
			
		}
		if(mode == 'range' || mode == 'days' || mode == 'calendar') {
			
			
			div_range_days_calendar_mode_show_hide();
			
		}
		if(mode == 'calendar') {
			//ZALADOWAC KALENDARZ CZEBA
			var dcd = new Date();
			load_calendar(dcd.getFullYear() + '-' + dcd.getMonth() + '-' + dcd.getDate());
		}
	
		update_summary();
	
	});
	
	/*-----------------------------------------------------
	/
	/		ZAKRES DATY
	/
	-----------------------------------------------------*/
		var daterangesettings = {
									format: 'YYYY-MM-DD',
									opens: 'right',
									separator: ' do ',
									ranges: {
										//'Wczoraj': [moment().subtract('days', 1), moment().subtract('days', 1)],
										//'Dziś': [moment(), moment()],
										'Najbliższe 3 dni': [moment().add('days', 3), moment().add('days', 5)],
										'Najbliższe 7 dni': [moment().add('days', 3), moment().add('days', 9)],
										'Najbliższe 2 tygodnie': [moment().add('days', 3), moment().add('days', 16)],
									},
									minDate: moment().add('days', 2),
									startDate: moment().add('days', 3),
									endDate: moment().add('days', 5),
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
								};
			
		$('#div_range_mode .dr_').daterangepicker(daterangesettings, function(start, end) {
				
               
				var difference = new Date(end.format('YYYY-MM-DD')) - new Date(start.format('YYYY-MM-DD'));
				var days = parseInt(	(difference/(3600*1000*24))	)+1	;
				
				$('#delivery_range_days').val(days);
				$('#delivery_range_start').val(start.format('YYYY-MM-DD'));
				$('#delivery_range_end').val(end.format('YYYY-MM-DD'));
				
				days_selected_recalculate_days('range');
				update_summary();
			}
		);
		
		//dni tygodnia
		$('body').on('change', '.delivery_week_day', function() {
			
			if(mode == 'range') {
				days_selected_recalculate_days('range');
			} else if(mode == 'days') {
				days_selected_recalculate_days('days');	
			}
			
			update_summary();
		
		});
		
	
	/*-----------------------------------------------------
	/
	/		ILOŚĆ DNI
	/
	-----------------------------------------------------*/
	
		$('body').on('focus', '#div_days_mode .dp_', function () {

			$(this).datetimepicker({
				format: 'yyyy-mm-dd',
				minView: 2,
				startView: 3,
				language: "pl"
			}).datetimepicker('setStartDate', new Date(moment().add('days', 3))).datetimepicker('update', new Date(moment().add('days', 3)));
			
		});
		
		$('body').on('change', '#delivery_days_start, #delivery_count_days', function() {
			days_selected_recalculate_days('days');	
			update_summary();	
		});
	
	/*-----------------------------------------------------
	/
	/		KALENDARZ
	/
	-----------------------------------------------------*/	
	
		//ZMIANA MIESIACA
		$('body').on('click', '#div_order_calculator_calendar .prev, #div_order_calculator_calendar .next', function () {
		
			var date = $(this).data('date');
			load_calendar(date);
			
		});	

	
		//WYBRANIE DNIA
		$('body').on('click', '#div_order_calculator_calendar .free', function () {
		
			$(this).removeClass('free');
			$(this).addClass('busy label label-primary');
			
			//dodaj
			days_selected_add_day($(this).data('date'));
			update_summary();
		
		});
		
		//ODZNACZENIE DNIA
		$('body').on('click', '#div_order_calculator_calendar .busy', function () {
			
			$(this).removeClass('busy label label-primary');
			$(this).addClass('free');
			
			//usuwam inputa
			days_selected_remove_day($(this).data('date'));
			update_summary();
	
		});
	
	
	
	
	/*-----------------------------------------------------
	/
	/		FUNKCJE
	/
	-----------------------------------------------------*/	
	
		function div_range_days_calendar_mode_show_hide() {
			if(diet == "kaloryczna") {
				$('#div_range_days_calendar_mode').hide();
				$('.delivery_meal').each(function() {
					this.checked = true;
					$(this).parent().addClass("active");
				});
			} else {
				$('#div_range_days_calendar_mode').show();
				$('.delivery_meal').each(function() {
					this.checked = false;
					$(this).parent().removeClass("active");
				});
			}	
		}

		function days_selected_add_day(date) {
			//dodaje inputa
			$('#div_order_delivery_days').append('<input type="hidden" name="delivery_day[]" id="delivery_day_' + date + '" value="' + date + '" />');	
			days_selected.push(	date  );
		}
		
		function days_selected_remove_day(date) {
			//usuwam inpute	
			$('#div_order_delivery_days #delivery_day_' + date).remove();
			days_selected[days_selected.indexOf(	date	)] = null;
			
			//usuwam nulle
			days_selected = jQuery.grep(days_selected, function(n, i){
				return (n !== "" && n != null);
			});
			
		}

		function days_selected_sort() {
			days_selected.sort(function(a__, b__) {
				var a_ = a__.split('-');
				var b_ = b__.split('-');
				a = new Date(a_[0], a_[1], a_[2]);
				b = new Date(b_[0], b_[1], b_[2]);
				
				return a<b?-1:a>b?1:0;
			});
		}
	
		function days_selected_recalculate_days(mode) {
			
			//tworze tablice z wybranymi dniami
			var pattern_days_selected = new Array();
			$('#delivery_week_days .delivery_week_day').each( function() {
				if(this.checked) {
					pattern_days_selected.push(parseInt($(this).val()));	
				}
			});
			
			//console.log('patter days selected:');
			//console.log(pattern_days_selected);
			
			//wykluczam niewybrane dni
			if(mode == 'range') {
				var days_selected_count = parseInt($('#delivery_range_days').val());
				var t = ($('#delivery_range_start').val()).split('-');
				t[1] = t[1]-1;
			} else if(mode == 'days') {
				var days_selected_count = parseInt($('#delivery_count_days').val());
				var t = ($('#delivery_days_start').val()).split('-');
				t[1] = t[1]-1;	
			}
			var start_date = new Date(t[0], t[1], t[2]);
			
			//console.log('start day: ' + start_date + ', day of week: ' + start_date.getDay());
			//console.log('days selected count:' + days_selected_count);
			
			//zeruje najwazniejsza tablice
			days_selected = new Array();
			
			//licze
			if(mode == 'range') {
				for (var i = 0; i < days_selected_count; i++) {	
				
					//sprawdzenie
					//console.log('index of ' + start_date.getDay() + ' is: ' + pattern_days_selected.indexOf(start_date.getDay()));
					
					if(pattern_days_selected.indexOf(start_date.getDay()) > -1) {
						//inkrementuje tablice
						dcd = start_date;
						days_selected_add_day(dcd.getFullYear() + '-' + (dcd.getMonth()+1) + '-' + dcd.getDate());
					}
					
					start_date.setDate(start_date.getDate()+1);
					
					//console.log('for loops');
					
				}
			} else if(mode == 'days') {
				var i = 0;
				var counter = 0; //na wszelki wypadek
				while(i < days_selected_count && counter < 1000) {	
				
					//sprawdzenie
					if(pattern_days_selected.indexOf(start_date.getDay()) > -1) {
						//inkrementuje tablice
						dcd = start_date;
						days_selected_add_day(dcd.getFullYear() + '-' + (dcd.getMonth()+1) + '-' + dcd.getDate());
						
						//inkrementqacja i
						i++;
					}
					
					start_date.setDate(start_date.getDate()+1);
					
					//console.log('while loops');
					counter++;
					
				}	
			}
			
		}
		
		
		function load_calendar(date) {
				
			if($('#order_calculator_calendar').length != 0) {
				
				var d = date.split('-');
				//console.log(d);
				var date = new Date(d[0], d[1], d[2]);
				//console.log(date);
				var date_prev = new Date(date.setMonth(date.getMonth() - 1));
				//console.log(date_prev);
				var date_next = new Date(date.setMonth(date.getMonth() + 2));
				//console.log(date_next);
				
				var user_id = $('#order_calculator_calendar').data('user_id');
				
				$.ajax({
					url: BASE_URL + 'page/calendar/' + date.getFullYear() + '-' + date.getMonth() + '-' + date.getDate() + ((user_id)?'/' + user_id:''),
					type: 'POST',
					dataType: 'html',
					data: { minDate: true },
					beforeSend  : function() {
						$('#preloader').show();
					},
					success: function(result) {	
					
						$('#preloader').hide();	
			
						$('#div_order_calculator_calendar #order_calculator_calendar').html(result);
						$('#div_order_calculator_calendar .prev').data('date', date_prev.getFullYear() + '-' + date_prev.getMonth() + '-' + date_prev.getDate());
						$('#div_order_calculator_calendar .next').data('date', date_next.getFullYear() + '-' + date_next.getMonth() + '-' + date_next.getDate());
						
						//aktualizauje
						days_selected.forEach(function(day) {
							$('#delivery_calendar_day_' + day).removeClass('free');
							$('#delivery_calendar_day_' + day).addClass('busy label label-primary');
						});	
						
						//wylacza stare dni
						$(".delivery_calendar .free").each(function( index ) {
							
							var date = new Date(moment(	$(this).data('date')	, "YYYY-MM-DD"));
							var date_max = new Date(moment(	).add('days', 3));
	
							//console.log(date);
	
							if(date <= date_max) {
	
								$(this).removeClass('free');
								$(this).addClass('muted tooltipa');
								$(this).attr('title', 'Nie możesz wybrać tak wczesnej daty!');

							}
				
						});
						
					}
				});	
			
			}
		}

		function update_summary() {
			
			//sortuj
			days_selected_sort();
			
			//liczy dni, wyznacza pierwszy i ostatni
			var count = 0;
			var first_day = null;
			var last_day = null;
			days_selected.forEach(function(day) {
				if(day != null) {
					if(count == 0) {
						first_day = day;	
					}
					last_day = day;
					count++;
				}
			});
			
			//CENY i dane, pobieram z php
			$.ajax({
				url: BASE_URL + 'order/get_prices',
				type: 'POST',
				dataType: 'json',
				data: { ajax : true },
				beforeSend  : function() {
					$('#preloader').show();
				},
				success: function(prices) {	
				
					console.log(prices);
					console.log(diet);

					//Sprawdzam zaznaczenia
					var meals = 0;
					$.each($('#delivery_calendar_day_selected_meals input'), function () {
						if(this.checked) {
							meals++;		
						}
					});
					
					//Musi byc wiecej niz 3
					//Jesli wybral kaloryczna to inaczej:
					if(diet == 'kaloryczna') {
						
						product_id = prices['kaloryczna'][sex]['5'][$('#diet_kaloryczna_calories').val()]['id'];
						product_price = prices['kaloryczna'][sex]['5'][$('#diet_kaloryczna_calories').val()]['price'];
						meals = 5;
						
					} else {
					
						if(meals >= 3) {
							
							//Jaki to produkt konkretnie?
							product_id = prices[diet][sex][meals]['id'];
							product_price = prices[diet][sex][meals]['price'];
							
						} else {
							product_id = null;
						}
					
					}
					
					//console.log(meals);
					//console.log(product_id);
					//console.log(days_selected);
					
					//Summary
					var text = '';
					if(count == 0 && product_id == null) {
						$('#div_btn_order').hide();
					} else if(count != 0  && product_id == null) {
						text = '<h4>Wybrałeś <span class="label label-primary">' + count + '</span> dni (od ' + first_day + ' do ' + last_day + ')</h4>';
						$('#div_btn_order').hide();
					} else if(count == 0  && product_id != null) {
						text = '<h4>Wybrałeś <span class="label label-primary">' + meals + '</span> posiłków dziennie za kwotę <span class="label label-success">' + product_price + '</span> zł/dzień</h4>';
						$('#div_btn_order').hide();
					} else {
						text = '<h4>Wybrałeś <span class="label label-primary">' + count + '</span> dni (od ' + first_day + ' do ' + last_day + ') x <span class="label label-primary">' + meals + '</span> posiłków dziennie w cenie <span class="label label-success">' + product_price + '</span> zł/dzień.</h4><h1 class="text-right"><span style="font-size: 18px;color: #ccc">do zapłaty</span> <span class="label label-danger">' + parseFloat(count*product_price) + ' PLN</span></h1><hr />';
						
						$('#div_btn_order').show();
						
					}
					
					$('#delivery_summary').html(text);


					$('#preloader').hide();

				
				}
			});	
				
				
			
			

			
		}
		


	/*-----------------------------------------------------
	/
	/		WYBÓR POSIŁKÓW
	/
	-----------------------------------------------------*/	
	
		$('body').on('change', '#delivery_calendar_day_selected_meals input', function () {
			
			update_summary();	
			
		});
		
	
	
	/*-----------------------------------------------------
	/
	/		OTWARCIE FORMULARZA
	/
	-----------------------------------------------------*/	
	
		function open_form() {
			
			if(product_id != null && days_selected.length > 0) {
				
				var meals_selected = [];
				$(".delivery_meal").each(function() {
					if(this.checked) {
						meals_selected.push($(this).val());
					}
				});
				
				$.ajax({
					url: BASE_URL + 'page/order_new/make_order',
					type: 'POST',
					dataType: 'html',
					data: { days_selected:days_selected, product_id:product_id, meals_selected:meals_selected },
					beforeSend  : function() {
						$('#preloader').show();
					},
					success: function(result) {	
						$('#preloader').hide();	
						
						$('#div_order_form').html(result);
						$('#order_modal_personal').modal('show');
					
					}
				});	
			
			} else {
				
			}	
		}
		
		//ZALOGOWANY
		$('body').on('click', '#div_btn_order .btn_open_form', function () {	
			open_form();
		});
	
		//NIEZALOGOWANY
		$('a.btn_popover_login').popover({'html' : true});
		
		$('body').on('click', '.btn_login, .btn_register', function () {
			
			//logowanie ajax
			if($(this).data('login') == true) {
				
				var email_ajax = $('#email_ajax').val();
				var password_ajax = $('#password_ajax').val();
				var redirect = $('#redirect').val();

				$.ajax({
					url: BASE_URL + 'user/login/' + redirect,
					type: 'POST',
					dataType: 'json',
					data: { email: email_ajax, password: password_ajax, ajax : true },
					beforeSend  : function() {
						$('#preloader').show();
					},
					success: function(result) {	
						$('#preloader').hide();	
						
						if(result == 'OK') {

							$('#btn_order.btn_popover_login').popover('hide');
							
							open_form();
							
							console.log('AJAX LOGIN OK');
		
						} else {
							console.log('AJAX LOGIN ERROR');
						}
						
					}
				});	
			
			} else {
				
				open_form();
					
			}

			return false;
			
		});
		
		
	/*-----------------------------------------------------
	/
	/		OFERTA
	/
	-----------------------------------------------------*/	

	if($('#anchor_offer').length > 0) {
		$("html, body").delay(100).animate({scrollTop: $('#anchor_offer').offset().top - 110}, 1000);
	}
		
	$('.offer_carousel').carousel({
		interval: false
	});
	
	//setTimeout(function() {
		
	var counter = 0;
	$('#offer_individual').on("mousewheel", function() {
		
		if(counter == 0) {
			$('#offer_individual').tooltip({
					title: 'Najedź myszką na opis, aby poznać szczegóły diety',
					placement : 'top'
				}
			).tooltip('show').next().css({'margin-top': 65, 'width' : 150});
			counter++;
		} 
		
	});
	/**/
	//}, 1000);
	

		
	$('body').on('mouseenter', '#offer_individual_carousel .info', function() {
		$('#offer_individual').tooltip('destroy');	
		$('#offer_individual_carousel').carousel(1);
	}).on('mouseleave', '#offer_individual', function() {
		$('#offer_individual_carousel').carousel(0);
	});
	
	$('body').on('mouseenter', '#offer_shape_carousel .info', function() {
		$('#offer_shape_carousel').carousel(1);
	}).on('mouseleave', '#offer_shape', function() {
		$('#offer_shape_carousel').carousel(0);	
	});
	
	$('body').on('mouseenter', '#offer_calories_carousel .info p', function() {
		$('#offer_calories_carousel').carousel(1);
	}).on('mouseleave', '#offer_calories', function() {
		$('#offer_calories_carousel').carousel(0);	
	});
	
	$('body').on('mouseenter', '#offer_nogluten_carousel .info', function() {
		$('#offer_nogluten_carousel').carousel(1);
	}).on('mouseleave', '#offer_nogluten', function() {
		$('#offer_nogluten_carousel').carousel(0);	
	});
	
	$('body').on('mouseenter', '#offer_vegetarian_carousel .info', function() {
		$('#offer_vegetarian_carousel').carousel(1);
	}).on('mouseleave', '#offer_vegetarian', function() {
		$('#offer_vegetarian_carousel').carousel(0);	
	});
	
	
	$('#offer_calories_tab').tab();
	
	
});
