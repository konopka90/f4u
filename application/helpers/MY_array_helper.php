<?php

function array_to_object($array) {
	$obj = new stdClass;
	foreach($array as $k => $v) {
		if(strlen($k)) {
			if(is_array($v)) {
				$obj->{$k} = array_to_object($v); //RECURSION
			} else {
				$obj->{$k} = $v;
			}
		}
	}
	return $obj;
} 

function printr($array) {
	echo '<pre style="text-align:left; font-size:12px; font-family:Consolas, Verdana">';
	print_r($array);
	echo '</pre>';
}

function flog($data) {
	$CI =& get_instance();
	$CI->firephp->log($data);	
}

function closest_number($array, $number) {

    sort($array);
    foreach ($array as $a) {
        if ($a >= $number) return $a;
    }
    return end($array);
	
}

function is_assoc($array) {
  return (bool)count(array_filter(array_keys($array), 'is_string'));
}

function create_multidimensional_array($id_name, $key, $parentId = FALSE, $array) {
	
    $multidimensional_array = array();

	if(is_array($array)) {
		foreach ($array as $row) {
			if ($row[$key] == $parentId) {
				$row['childs'] = create_multidimensional_array($id_name, $key, $row[$id_name], $array);
				$multidimensional_array[$row[$id_name]] = $row;
			}
		}
	}

    return $multidimensional_array;
	
}

function make_link_structure($id_name, $table, $array, $link = array(), &$link_array = array()) {
	if(is_array($array)) {
		foreach ($array as $v) {
			
			$link[(int)$v[(string)$id_name]] = link_exist(clean_chars((($v['name'])?$v['name']:$v['title'])), $v[(string)$id_name], $table);
			
			//w tym miejscu musi być zapis linku
			$link_array[$v[(string)$id_name]] = $link;
			
			if(is_array($v['childs'])) {
				make_link_structure($id_name, $table, $v['childs'], $link, $link_array);
			}
			
			array_pop($link);	
			if(!is_array($link)) {
				$link = array();	
			}
		}
		return $link_array;
	}
}

function set_array_keys($array, $key) {
	
	$result = array();
	if(!empty($array)) {
		foreach($array as $i => $a) {
			$result[$a->$key] = $a;	
		}
	}
	
	return $result;
	
}

function set_array_keys_multi($array, $key) {
	
	$result = array();
	if(!empty($array)) {
		foreach($array as $i => $a) {
			$result[$a->$key][] = $a;	
		}
	}
	
	return $result;
	
}

function get_array_keys_values($table) {
	$result = array();
	if(!empty($table)) {
		foreach($table as $key => $values) {
			array_push($result, $key);
		}
	}
	return $result;
}

function make_array_keys_like_values($table) {
	$result = array();
	if(!empty($table)) {
		foreach($table as $key => $value) {
			$result[$value] = $value;
		}
	}
	return $result;
}

function set_twodimensial_array_keys($array, $key_one, $key_two = FALSE) {

	foreach($array as $i => $a) {
		if($key_two == FALSE) {
			$result[$a->$key_one][] = $a;	
		} else {
			$result[$a->$key_one][$a->$key_two] = $a;
		}
	}
	
	return $result;
	
}

	
	function link_exist($link, $id, $table) {
		
		$link_query = array();
				
		if(in_array($link, $link_query)) {
			return $link.'_'.$id;
		} else {
			return $link;	
		}
	
	}
	
	
function get_extension($file) {
	$extension = strtolower(substr(strrchr($file, '.'), 1));
	return $extension;	
}


function clean_chars($text) {
	$chars = array(
	   //WIN
		"\xb9" => "a", "\xa5" => "A", "\xe6" => "c", "\xc6" => "C",
		"\xea" => "e", "\xca" => "E", "\xb3" => "l", "\xa3" => "L",
		"\xf3" => "o", "\xd3" => "O", "\x9c" => "s", "\x8c" => "S",
		"\x9f" => "z", "\xaf" => "Z", "\xbf" => "z", "\xac" => "Z",
		"\xf1" => "n", "\xd1" => "N",
	   //UTF
		"\xc4\x85" => "a", "\xc4\x84" => "A", "\xc4\x87" => "c", "\xc4\x86" => "C",
		"\xc4\x99" => "e", "\xc4\x98" => "E", "\xc5\x82" => "l", "\xc5\x81" => "L",
		"\xc3\xb3" => "o", "\xc3\x93" => "O", "\xc5\x9b" => "s", "\xc5\x9a" => "S",
		"\xc5\xbc" => "z", "\xc5\xbb" => "Z", "\xc5\xba" => "z", "\xc5\xb9" => "Z",
		"\xc5\x84" => "n", "\xc5\x83" => "N",
	   //ISO
		"\xb1" => "a", "\xa1" => "A", "\xe6" => "c", "\xc6" => "C",
		"\xea" => "e", "\xca" => "E", "\xb3" => "l", "\xa3" => "L",
		"\xf3" => "o", "\xd3" => "O", "\xb6" => "s", "\xa6" => "S",
		"\xbc" => "z", "\xac" => "Z", "\xbf" => "z", "\xaf" => "Z",
		"\xf1" => "n", "\xd1" => "N", 
	
		' '=>'_',
		'-'=>'',
	
		'"'=>'',
		"'"=>'',
		'/'=>'',
	
		'!'=>'',
		"@"=>'',
		'#'=>'',
		'$'=>'',
		'%'=>'',
		'^'=>'',
		'&'=>'',
		'*'=>'',
		'('=>'',
		')'=>'',
		"["=>'',
		']'=>'',
		'{'=>'',
		'}'=>'',
		"~"=>'',
		'`'=>'',
	
		':'=>'',
		';'=>'',
		'<'=>'',
		'>'=>'',    
		'/'=>'',
		'?'=>'',
		','=>'',
	
		'+'=>'',
		'__'=>'_',
		'='=>'');
		
	$result = strtr($text, $chars);
	$result = strtolower($result);
	return $result; 

}

function get_yt_id($text) {
    $text = preg_replace('~
        # Match non-linked youtube URL in the wild. (Rev:20111012)
        https?://         # Required scheme. Either http or https.
        (?:[0-9A-Z-]+\.)? # Optional subdomain.
        (?:               # Group host alternatives.
          youtu\.be/      # Either youtu.be,
        | youtube\.com    # or youtube.com followed by
          \S*             # Allow anything up to VIDEO_ID,
          [^\w\-\s]       # but char before ID is non-ID char.
        )                 # End host alternatives.
        ([\w\-]{11})      # $1: VIDEO_ID is exactly 11 chars.
        (?=[^\w\-]|$)     # Assert next char is non-ID or EOS.
        (?!               # Assert URL is not pre-linked.
          [?=&+%\w]*      # Allow URL (query) remainder.
          (?:             # Group pre-linked alternatives.
            [\'"][^<>]*>  # Either inside a start tag,
          | </a>          # or inside <a> element text contents.
          )               # End recognized pre-linked alts.
        )                 # End negative lookahead assertion.
        [?=&+%\w-]*        # Consume any URL (query) remainder.
        ~ix', 
        '$1',
        $text);
    return $text;
}


function get_last_video_from_yt_channel($username = 'YouTube') {
	
	$id = NULL;

	$xml = simplexml_load_file(sprintf('http://gdata.youtube.com/feeds/base/users/%s/uploads?alt=rss&v=2&orderby=published', $username));
	
	if ( ! empty($xml->channel->item[0]->link) )
	{
	  parse_str(parse_url($xml->channel->item[0]->link, PHP_URL_QUERY), $url_query);
	
	  if ( ! empty($url_query['v']) )
		$id = $url_query['v'];
	}
	
	echo $id;
}


function generate_token($length) {
	$token = substr(md5(uniqid(time())), 0 - $length); 

	for($i = 0; $i < strlen($token); $i++) { 
	   if(($token{$i} >= 'a' and $token{$i} <= 'z') and (rand(0, 10) > 5)) { 
		  $token{$i} = strtoupper($token{$i}); 
	   } 
	} 
	return $token;
}

function make_color($img, $color) { 
   if(is_resource($img) and preg_match('/^#[a-f0-9]{6}$/i', $color)) { 
	  $color = substr($color, 1); 
	  $rgb = array(); 
	   
	  for($i = 0; $i < 6; $i += 2) { 
		 $rgb[] = (int)hexdec($color{$i}.$color{$i + 1}); 
	  } 

	  return imagecolorallocate($img, $rgb[0], $rgb[1], $rgb[2]); 
   } else { 
	  return 0; 
   } 
} 


function sort_result($result, $keyword) {
	function by($a, $b, $keyword) {
		return strcmp($a->{$keyword}, $b->{$keyword});
	}
	
	usort($result, create_function('$a, $b', 'return by($a, $b, "'.$keyword.'");'));
	return $result;	
}



function say_number($kwota = 0) {
	$wyrazenie1 = NULL;
	$wyrazenie2 = NULL;
	$wyrazenie3 = NULL;
	$wyrazenie4 = NULL;
	$wyrazenie5 = NULL;
	$wyrazenie6 = NULL;
	
	$kwota = str_replace(",", ".", $kwota);
	$tmp = explode(".", $kwota);
	$zlote = $tmp[0];
	if(array_key_exists(1, $tmp)) {
		$grosze = $tmp[1];
	} else {
		$grosze = '00';
	}
	if(strlen($grosze)==1) $grosze .= '0';
	$dl = strlen($zlote);

	$wyr_1 = '';
	$wyr_2 = '';
	$wyr_3 = '';
	$wyr_4 = '';	
	$wyr_5 = '';	
	$wyr_6 = '';	
	// długość
	switch($dl) {
		case 1: 
			$wyr_1 = $zlote[0];
		break;

		case 2: 
			$wyr_1 = $zlote[1];
			$wyr_2 = $zlote[0];
		break;
		
		case 3: 
			$wyr_1 = $zlote[2];
			$wyr_2 = $zlote[1];
			$wyr_3 = $zlote[0];
		break;

		case 4: 
			$wyr_1 = $zlote[3];
			$wyr_2 = $zlote[2];
			$wyr_3 = $zlote[1];
			$wyr_4 = $zlote[0];
		break;

		case 5: 
			$wyr_1 = $zlote[4];
			$wyr_2 = $zlote[3];
			$wyr_3 = $zlote[2];
			$wyr_4 = $zlote[1];
			$wyr_5 = $zlote[0];
		break;

		case 6: 
			$wyr_1 = $zlote[5];
			$wyr_2 = $zlote[4];
			$wyr_3 = $zlote[3];
			$wyr_4 = $zlote[2];
			$wyr_5 = $zlote[1];
			$wyr_6 = $zlote[0];
		break;
	}

	$wyrazenie5 = '';

	// wyraz szósty
	switch($wyr_6) {
		case 0: $wyrazenie6 =  ""; break;
		case 1: $wyrazenie6 = "sto "; break;
		case 2: $wyrazenie6 = "dwieście "; break;
		case 3: $wyrazenie6 = "trzysta "; break;
		case 4: $wyrazenie6 = "czterysta "; break;
		case 5: $wyrazenie6 = "pięćset "; break;
		case 6: $wyrazenie6 = "sześćset "; break;
		case 7: $wyrazenie6 = "siedemset "; break;
		case 8: $wyrazenie6 = "osiemset "; break;
		case 9: $wyrazenie6 = "dziewięćset "; break;
	}
	
	

	if($wyr_5==1) 	{

		switch($wyr_4) {
			case 0: $wyrazenie4 = "dziesięć tysięcy "; break;
			case 1: $wyrazenie4 = "jedenaście tysięcy "; break;
			case 2: $wyrazenie4 = "dwanaście tysięcy "; break;
			case 3: $wyrazenie4 = "trzynaście tysięcy "; break;
			case 4: $wyrazenie4 = "czternaście tysięcy "; break;
			case 5: $wyrazenie4 = "piętnaście tysięcy "; break;
			case 6: $wyrazenie4 = "szesnaście tysięcy "; break;
			case 7: $wyrazenie4 = "siedemnaście tysięcy "; break;
			case 8: $wyrazenie4 = "osiemnaście tysięcy "; break;
			case 9: $wyrazenie4 = "dziewiętnaście tysięcy "; break;
		}
	
	} else {

		// wyraz piąty
		
		switch($wyr_5) {
			case 0: $wyrazenie5 =  ""; break;
			case 1: $wyrazenie5 =  "jeden "; break;
			case 2: $wyrazenie5 =  "dwadzieścia "; break;
			case 3: $wyrazenie5 =  "trzydzieści "; break;
			case 4: $wyrazenie5 =  "czterdzieści "; break;
			case 5: $wyrazenie5 =  "pięćdzieściąt "; break;
			case 6: $wyrazenie5 =  "sześćdziesiąt "; break;
			case 7: $wyrazenie5 =  "siedemdziesiąt "; break;
			case 8: $wyrazenie5 =  "osiemdziesiąt "; break;
			case 9: $wyrazenie5 =  "dziewięćdziesiąt "; break;
		}

		// wyraz czwarty
		switch($wyr_4) {
			case 0: $wyrazenie4 = ""; break;
			case 1: $wyrazenie4 = "tysiąc "; break;
			case 2: $wyrazenie4 = "dwa tysiące "; break;
			case 3: $wyrazenie4 = "trzy tysiące "; break;
			case 4: $wyrazenie4 = "cztery tysiące "; break;
			case 5: $wyrazenie4 = "pięć tysięcy "; break;
			case 6: $wyrazenie4 = "sześć tysięcy "; break;
			case 7: $wyrazenie4 = "siedem tysięcy "; break;
			case 8: $wyrazenie4 = "osiem tysięcy "; break;
			case 9: $wyrazenie4 = "dziewięć tysięcy "; break;
		}
	}
		

	// wyraz trzeci
	switch($wyr_3) {
		case 0: $wyrazenie3 =  ""; break;
		case 1: $wyrazenie3 = "sto "; break;
		case 2: $wyrazenie3 = "dwieście "; break;
		case 3: $wyrazenie3 = "trzysta "; break;
		case 4: $wyrazenie3 = "czterysta "; break;
		case 5: $wyrazenie3 = "pięćset "; break;
		case 6: $wyrazenie3 = "sześćset "; break;
		case 7: $wyrazenie3 = "siedemset "; break;
		case 8: $wyrazenie3 = "osiemset "; break;
		case 9: $wyrazenie3 = "dziewięćset "; break;
	}


	if($wyr_2==1) 	{

		switch($wyr_1) {
			case 0: $wyrazenie2 = "dziesięć"; break;
			case 1: $wyrazenie2 = "jedenaście"; break;
			case 2: $wyrazenie2 = "dwanaście"; break;
			case 3: $wyrazenie2 = "trzynaście"; break;
			case 4: $wyrazenie2 = "czternaście"; break;
			case 5: $wyrazenie2 = "piętnaście"; break;
			case 6: $wyrazenie2 = "szesnaście"; break;
			case 7: $wyrazenie2 = "siedemnaście"; break;
			case 8: $wyrazenie2 = "osiemnaście"; break;
			case 9: $wyrazenie2 = "dziewiętnaście"; break;
		}
	
	} else {

		// wyraz drugi
		
		switch($wyr_2) {
			case 0: $wyrazenie2 =  ""; break;
			case 1: $wyrazenie2 =  "jeden "; break;
			case 2: $wyrazenie2 =  "dwadzieścia "; break;
			case 3: $wyrazenie2 =  "trzydzieści "; break;
			case 4: $wyrazenie2 =  "czterdzieści "; break;
			case 5: $wyrazenie2 =  "pięćdzieściąt "; break;
			case 6: $wyrazenie2 =  "sześćdziesiąt "; break;
			case 7: $wyrazenie2 =  "siedemdziesiąt "; break;
			case 8: $wyrazenie2 =  "osiemdziesiąt "; break;
			case 9: $wyrazenie2 =  "dziewięćdziesiąt "; break;
		}

		// wyraz pierwszy
		switch($wyr_1) {
			case 0: $wyrazenie1 =  " złotych"; break;
			case 1: $wyrazenie1 = "jeden złoty"; break;
			case 2: $wyrazenie1 = "dwa złote"; break;
			case 3: $wyrazenie1 = "trzy złote"; break;
			case 4: $wyrazenie1 = "cztery złote"; break;
			case 5: $wyrazenie1 = "pięć złotych"; break;
			case 6: $wyrazenie1 = "sześć złotych"; break;
			case 7: $wyrazenie1 = "siedem złotych"; break;
			case 8: $wyrazenie1 = "osiem złotych"; break;
			case 9: $wyrazenie1 = "dziewięć złotych"; break;
		}
	}
	
	return $wyrazenie6.$wyrazenie5.$wyrazenie4.$wyrazenie3.$wyrazenie2.$wyrazenie1.', '.$grosze.'/100 groszy';

}



?>