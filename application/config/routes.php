<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "page";
$route['404_override'] = '';
$route['page/unsubscribe_newsletter/(:any)'] = 'page/unsubscribe_newsletter/$1';

$route['page/login'] = 'user/login/page';
$route['admin/login'] = 'user/login/admin';
$route['cp/login'] = 'user/login/cp';
$route['cp/login/(:any)'] = 'user/login/$1';

//PAGE
$route['page/order/make'] = 'order/make_order';
$route['page/order/dotpay'] = 'order/dotpay';
$route['page/order/after_payment/(:any)'] = 'order/after_payment/$1';
$route['page/order/after_payment'] = 'order/after_payment';
$route['page/order/(:any)'] = 'page/order/$1';

$route['page/order_new'] = 'page/order_new';
$route['page/order_new/(:any)'] = 'page/order_new/$1';

$route['page/calendar/(:any)'] = 'page/calendar/$1';

$route['page/(:any)'] = "page/any/$1";


//CONSULTATION
$route['consultation/order/make'] = 'order/make_order/consultation';
$route['consultation/offer/(:any)'] = 'consultation/offer/$1';

//CP
$route['cp'] = 'cp/delivery';

$route['cp/order/(:num)/save'] = 'cp/packets/order_pdf/$1';
$route['cp/order/(:num)'] = 'cp/packets/order/$1';

//SP
$route['sp'] = 'sp/summary';
//$route['sp/(:any)'] = 'sp/summary/index/$1';



//ADMIN
$route['admin/delivery/(:num)/download/pdf'] = 'admin/delivery/get_pdf/$1';
$route['admin/delivery/(:num)/download/xls'] = 'admin/delivery/get_xls/$1';
$route['admin/delivery/download'] = 'admin/delivery/get';
$route['admin/delivery/download_statistics'] = 'admin/delivery/get_statistics';
	
	//PRODUKTY
	$route['admin/product/update/catering/(:num)'] = 'admin/product/create/$1/catering';
	$route['admin/product/create/catering'] = 'admin/product/create/0/catering';
	
	$route['admin/product/update/(:num)'] = 'admin/product/create/$1';
	$route['admin/product/create'] = 'admin/product/create';
	
	$route['admin/seller/update/(:num)'] = 'admin/seller/create/$1';
	$route['admin/seller/create'] = 'admin/seller/create';
	
	//NEWSLETTER
	$route['admin/newsletter/email/remove/(:num)'] = 'admin/newsletter/email_remove/$1';

	$route['admin'] = 'admin/delivery';



/* End of file routes.php */
/* Location: ./application/config/routes.php */