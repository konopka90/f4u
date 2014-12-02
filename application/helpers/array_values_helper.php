<?

function get_free_days($days) {
	
	switch($days) {
		case $days >= 40:
			return 2;
		case $days >= 30:
			return 1;
		default:
			return 0;
	}
	
}

function provision_payout_realisation_values($id = FALSE) {
	
	$values = array("1" => array("Oczekuje na realizacje", 'label-info'), 
					"2" => array("Zrealizowano", 'label-success'),
					"3" => array("Odrzucono", 'label-danger'),
					);		
																	
	return ($id !== FALSE ) ? $values[$id] : $values;
	
}

function payment_method_values($id = FALSE) {
	
	$values = array("1" => array("Płatność gotówką", ''), 
					"2" => array("Płatność przelewem", ''),
					);		
																	
	return ($id !== FALSE ) ? $values[$id] : $values;
	
}

function dotpay_values($status = FALSE) {
	
	$status_values = array(	"0" => array("NIEZAPŁACONE", 'label-important label-danger'), 
							"1" => array("NOWA", 'label-info'),
							"2" => array("ZAKSIĘGOWANO", 'font_green label-success'), //czyli WYKONANO, pieniązki na koncie
							"3" => array("ODMOWNA", 'label-warning'),
							"4" => array("ANULOWANA/ZWROT", 'label-warning'),
							"5" => array("REKLAMACJA", 'label-warning')
							);		
																	
	return ($status !== FALSE ) ? $status_values[$status] : $status_values;
	
}


function packets_names_values($status = FALSE) {
	
	$status_values = array(	"individual" => array("Individual", ''), 
							"fit_for_family" => array("Fit For Family", ''), 
							"fit_for_junior" => array("Fit For Junior", ''), 
							"new_way" => array("New Way", '')
							);		
																	
	return ($status !== FALSE ) ? $status_values[$status] : $status_values;
	
}



function packets_weeks_values($status = FALSE) {
	
	$status_values = array(	"tygodni_8" => array("8 tygodni", ''), 
							"tygodni_6" => array("6 tygodni", ''), 
							"tygodni_4" => array("4 tygodnie", ''), 
							"tygodni_2" => array("2 tygodnie", ''), 
							"tydzien_1" => array("1 tydzień", ''), 
							"dni_3" => array("3 dni", '')	
							);		
																	
	return ($status !== FALSE ) ? $status_values[$status] : $status_values;
	
}


function packets_days_per_week_values($status = FALSE) {
	
	$status_values = array(	"dni_7" => array("7 dni", ''), 
							"dni_6" => array("6 dni", ''), 
							"dni_5" => array("5 dni", ''), 
							"dni_3" => array("3 dni", '')
							);		
																	
	return ($status !== FALSE ) ? $status_values[$status] : $status_values;
	
}

function packets_meals_per_day_values($status = FALSE) {
	
	$status_values = array(	"posilkow_9" => array("9 posiłków", ''), 
							"posilkow_8" => array("8 posiłków", ''), 
							"posilkow_7" => array("7 posiłków", ''), 
							"posilkow_6" => array("6 posiłków", ''), 
							"posilkow_5" => array("5 posiłków", ''), 
							"posilkow_4" => array("4 posiłki", ''), 
							"posilkow_3" => array("3 posiłki", ''),
							"posilkow_2" => array("2 posiłki", ''),
							"posilkow_1" => array("1 posiłek", '')
							);		
																	
	return ($status !== FALSE ) ? $status_values[$status] : $status_values;
	
}

function delivery_hours_values($status = FALSE) {
	
	$status_values = array(	"1" => array("6:00 - 6:30", ''), 
							"2" => array("6:30 - 7:00", ''), 
							"3" => array("7:00 - 7:30", ''), 
							"4" => array("7:30 - 8:00", ''), 
							"5" => array("8:00 - 8:30", ''), 
							"6" => array("8:30 - 9:00", ''), 
							"7" => array("9:00 - 9:30", ''),
							"8" => array("9:30 - 10:00", '')
							);		
																	
	return ($status !== FALSE ) ? $status_values[$status] : $status_values;
	
}




function dotpay_channels_values($status = FALSE) {

    $status_values = array(
							//0 => 'Karta VISA, MasterCard, JCB, Diners Club',
							245 => 'First Data Polska S.A. ',
							
							1 => 'mTransfer (mBank)',
							2 => 'Płacę z Inteligo (konto Inteligo)',
							3 => 'MultiTransfer (MultiBank)',
							4 => 'Płacę z iPKO (Bank PKO BP)',
							6 => 'Przelew24 (BZWBK)',
							7 => 'ING Bank Śląski S.A',
							
							10 => 'Millennium Bank S.A.',
							14 => 'Kredyt Bank S.A.',
							15 => 'Bank PKO BP (iPKO)',
							16 => 'Credit Agricole Bank Polska S.A.',
							
							
							17 => 'Płać z Nordea',
							18 => 'Przelew z BPH',
							
							25 => 'Invest Bank S.A.',
							27 => 'Bank BGŻ S.A. ',
							32 => 'BNP Paribas',
							33 => 'Volkswagen Bank Polska ',
							43 => 'BS Wschowa',
							47 => 'Polbank EFG ',
							57 => 'Getin Noble Bank S.A. ',
							61 => 'Bank Pocztowy',
							62 => 'Bank DnB NORD Polska S.A. ',

							36 => 'Bank Pekao S.A.',
							38 => 'ING Bank Śląski S.A. ',
							44 => 'Millennium Bank S.A',
							45 => 'Alior Bank S.A. (Płacę z Alior Bankiem )',
							46 => 'Citi Bank Handlowy S.A.',
							48 => 'Raiffeisen Bank Polska S.A.',
							49 => 'Meritum Bank S.A. ',
							50 => 'Toyota Bank Polska',
							51 => 'BOŚ Bank S.A.',
							56 => 'Eurobank',
							
							58 => 'Deutsche Bank PBC S.A. ',
							60 => 'Alior Bank S.A. (Płacę z Alior Sync)',
							63 => 'Bank PKO BP (Płacę z IKO)',
							65 => 'Idea Bank S.A. (Płacę z Idea Bank)',
							
							11  => 'Przekaz/Przelew bankowy',
							21  => 'Moje Rachunki',
							31  => 'Zapłać w Żabce i we Freshmarkecie',
							35  => 'Kantor Polski',
							
							22 => 'Smart Voucher Limited ',
							24 => 'mPay S.A. ',
							52 => 'SkyCash Poland S.A. S',
							64 => 'Bank Pekao S.A',
							
							212 => 'PayPal',
							20 => 'Dotpay',
							55 => 'Alior Raty Sp. z o.o. ',
		
						);
																				
	return ($status !== FALSE ) ? $status_values[$status] : $status_values;
	
}

		
function load_js($controler = FALSE) {
	
	$values = array("packets_prolong" => array('page_any'), 
					"seller_details" => array('order_index', 'user_index'), 
					);		
	
	if($controler !== FALSE) {
		if(array_key_exists( $controler , $values )) {
			return $values[$controler];	
		} else {
			return FALSE;
		}
	} else {
		return $values;
	}
	
}
		
					
									
									


?>