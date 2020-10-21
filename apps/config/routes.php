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

if( file_exists(__DIR__ . '/module_routes.php') )
{
	require __DIR__ . '/module_routes.php';
}

$route['default_controller'] = "dashboard";
$route['404_override'] = '';

$route['^(en|id)/reset_all_config'] = "dashboard/reset_all_config";
$route['^(en|id)/get_support_box_form'] = 'dashboard/get_support_box_form';
$route['^(en|id)/save_feedback'] = 'dashboard/save_feedback';
$route['^(en|id)/screen_shot'] = 'dashboard/screen_shot';
$route['^(en|id)/single_upload_support_box'] = 'dashboard/single_upload_support_box';

$route['login'] = 'authentication/login';
$route['^(en|id)/login'] = 'authentication/login';
$route['logout'] = 'authentication/logout';
$route['^(en|id)/logout'] = 'authentication/logout';
$route['^(en|id)/reset_pass'] = 'authentication/reset_pass';
$route['^(en|id)/get_password_form'] = 'authentication/get_password_form';
$route['^(en|id)/update_password'] = 'authentication/update_password';
$route['^(en|id)/screenlock'] = 'authentication/screenlock';
$route['screenlock'] = 'authentication/screenlock';

$route['^(en|id)/recruitment/appform'] = 'appform/kiosk';
$route['^(en|id)/recruitment/form'] = 'recruitform/kiosk';

$route['^(en|id)/admin/modules/create_routes'] = 'module/create_routes';

$route['^(en|id)/ms_to_my/import'] = 'ms_to_my/import';
$route['^(en|id)/(.+)$'] = "$2";
$route['^(en|id)$'] = $route['default_controller'];


/* End of file routes.php */
/* Location: ./application/config/routes.php */