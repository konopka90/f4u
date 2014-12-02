<?


function set_cookie($name = '', $value = '', $expire = '', $domain = '', $path = '/', $prefix = '', $secure = FALSE) {
	
	// Set the config file options
	$CI =& get_instance();
	//$CI->input->set_cookie($name, $value, $expire, $domain, $path, $prefix, $secure);
	
	if(!$expire) {
		$expire = time() + $CI->config->item('sess_expiration');	
	}

	// Enable sending of a P3P header
	header('P3P: CP="CUR ADM"');

	if (version_compare(PHP_VERSION, '5.2.0', '>=')) {
		return setcookie($name, $value, $expire, $path, $domain, $secure, true);
	} else {
		return setcookie($name, $value, $expire, $path.'; HttpOnly', $domain, $secure);
	}
	
}




?>