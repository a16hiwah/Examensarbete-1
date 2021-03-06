<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['my-account'] = 'my_account/overview';
$route['my-account/overview'] = 'my_account/overview';
$route['my-account/my-resources'] = 'my_account/my_resources';
$route['my-account/my-collections'] = 'my_account/my_collections';
$route['my-account/my-comments'] = 'my_account/my_comments';

$route['edit-profile'] = 'edit_user/edit_profile';

$route['user/(:any)'] = 'show_user/show_user/$1';

$route['sign-in'] = 'sign_in';
$route['sign-out'] = 'sign_out';

$route['resources/view/(:any)'] = 'resources/view/$1';
$route['resources/create-resource'] = 'resources/create_edit_resource';
$route['resources/delete-resource/(:num)/(:num)'] = 'resources/delete_resource/$1/$2';
$route['resources/edit-resource/(:num)/(:num)/(:num)'] = 'resources/create_edit_resource/$1/$2/$3';

$route['default_controller'] = 'home';
