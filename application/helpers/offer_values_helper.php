<?

//MUSI POKRYWAĆ SIĘ Z BAZĄ DANYCH!
function offer_values($key = FALSE) {
	
	$array = array(	
	
		"individual" => array(
			'name' => 'Individual',
			'male' => array(
				'5' => array(
					'price' => 75.00,
					'id' => 166
				),
				'4' => array(
					'price' => 70.00,
					'id' => 167
				),
				'3' => array(
					'price' => 65.00,
					'id' => 168
				),
			),
			'female' => array(
				'5' => array(
					'price' => 65.00,
					'id' => 169
				),
				'4' => array(
					'price' => 60.00,
					'id' => 170
				),
				'3' => array(
					'price' => 55.00,
					'id' => 171
				)
			),
		), 
		
		"shape" => array(
			'name' => 'Shape',
			'male' => array(
				'5' => array(
					'price' => 75.00,
					'id' => 172
				),
				'4' => array(
					'price' => 70.00,
					'id' => 173
				),
				'3' => array(
					'price' => 65.00,
					'id' => 174
				),
			),
			'female' => array(
				'5' => array(
					'price' => 75.00,
					'id' => 172
				),
				'4' => array(
					'price' => 70.00,
					'id' => 173
				),
				'3' => array(
					'price' => 65.00,
					'id' => 174
				)
			),
		),
		
		"kaloryczna" => array(
			'name' => 'Kaloryczna',
			'male' => array(
				'5' => array(
					'1000' => array(
						'price' => 49.00,
						'id' => 178
					),
					'1200' => array(
						'price' => 54.00,
						'id' => 179
					),
					'1500' => array(
						'price' => 63.00,
						'id' => 180
					),
					'1700' => array(
						'price' => 68.00,
						'id' => 181
					),
					'2000' => array(
						'price' => 73.00,
						'id' => 182
					),
				)
			),
			'female' => array(
				'5' => array(
					'1000' => array(
						'price' => 49.00,
						'id' => 178
					),
					'1200' => array(
						'price' => 54.00,
						'id' => 179
					),
					'1500' => array(
						'price' => 63.00,
						'id' => 180
					),
					'1700' => array(
						'price' => 68.00,
						'id' => 181
					),
					'2000' => array(
						'price' => 73.00,
						'id' => 182
					),
				)
			),
		), 
		"bezglutenowa" => array(
			'name' => 'Bezglutenowa',
			'male' => array(
				'5' => array(
					'price' => 75.00,
					'id' => 183
				),
				'4' => array(
					'price' => 70.00,
					'id' => 184
				),
				'3' => array(
					'price' => 65.00,
					'id' => 185
				),
			),
			'female' => array(
				'5' => array(
					'price' => 65.00,
					'id' => 186
				),
				'4' => array(
					'price' => 60.00,
					'id' => 187
				),
				'3' => array(
					'price' => 55.00,
					'id' => 188
				)
			),
		),
		"wegetarianska" => array(
			'name' => 'Wegetariańska',
			'male' => array(
				'5' => array(
					'price' => 75.00,
					'id' => 189
				),
				'4' => array(
					'price' => 70.00,
					'id' => 190
				),
				'3' => array(
					'price' => 65.00,
					'id' => 191
				),
			),
			'female' => array(
				'5' => array(
					'price' => 65.00,
					'id' => 192
				),
				'4' => array(
					'price' => 60.00,
					'id' => 193
				),
				'3' => array(
					'price' => 55.00,
					'id' => 194
				)
			),
		),
	);
											
	return ($key !== FALSE ) ? $array[$key] : $array;
	
}



?>