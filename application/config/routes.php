<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

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

$route['default_controller'] = "front/home/home";
$route['404_override'] = '';
$route['front/'] = "front/home/home";
$route['front/(:any)'] = "front/home/home";

/* Base URL */
$base_url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

/* Dynamic Route Path */
$pos = strpos($base_url, "admin");
if (strpos($base_url, "/admin/"))
{
    $expo1 = explode("admin/", $base_url);
    $config['base_url'] = $expo1[0];
    $expp = !empty($expo1[1]) ? $expo1[1] : '';
    $expo = explode("/", $expp);
    $conntrol = !empty($expo['0']) ? $expo['0'] : '';
    $flag = '1';
}
elseif (strpos($base_url, "/ws/"))
{
    $expo1 = explode("ws/", $base_url);
    $config['base_url'] = $expo1[0];
    $expp = !empty($expo1[1]) ? $expo1[1] : '';
    $expo = explode("/", $expp);
    $conntrol = !empty($expo['0']) ? $expo['0'] : '';
    $flag = '2';
}
else
{
    $config['base_url'] = $base_url;
    $flag = '3';
    if (!empty($_SERVER['ORIG_PATH_INFO'])) {
        $expo1 = explode("/", $_SERVER['ORIG_PATH_INFO']);
    } elseif (!empty($_SERVER['PATH_INFO'])) {
        $expo1 = explode("/", $_SERVER['PATH_INFO']);
    } else {
        $expo1 = explode("/", $_SERVER['REQUEST_URI']);
    }
    $conntrol = !empty($expo1['1']) ? $expo1['1'] : '';
}

if ($flag == 1)
{
    $route['admin/' . $conntrol] = "admin/" . $conntrol . "/" . $conntrol . "_control";
    $route['admin/' . $conntrol . '/new_user'] = 'admin/' . $conntrol . '/' . $conntrol . '_control/new_user';
    $route['admin/' . $conntrol . '/upload_profile'] = 'admin/' . $conntrol . '/' . $conntrol . '_control/upload_profile';
    $route['admin/' . $conntrol . '/truncate'] = 'admin/' . $conntrol . '/' . $conntrol . '_control/truncate';
    $route['admin/' . $conntrol . '/add_record'] = 'admin/' . $conntrol . '/' . $conntrol . '_control/add_record';
    $route['admin/' . $conntrol . '/check_user'] = 'admin/' . $conntrol . '/' . $conntrol . '_control/check_user';
    $route['admin/' . $conntrol . '/add_record/(:num)'] = 'admin/' . $conntrol . '/' . $conntrol . '_control/add_record';
    $route['admin/' . $conntrol . '/insert_data'] = 'admin/' . $conntrol . '/' . $conntrol . '_control/insert_data';
    $route['admin/' . $conntrol . '/edit_record/(:num)'] = 'admin/' . $conntrol . '/' . $conntrol . '_control/edit_record';
    $route['admin/' . $conntrol . '/edit_record/(:num)/(:num)'] = 'admin/' . $conntrol . '/' . $conntrol . '_control/edit_record';
    $route['admin/' . $conntrol . '/view_record'] = 'admin/' . $conntrol . '/' . $conntrol . '_control/view_record';
    $route['admin/' . $conntrol . '/view_record/(:num)'] = 'admin/' . $conntrol . '/' . $conntrol . '_control/view_record';
    $route['admin/' . $conntrol . '/update_data'] = 'admin/' . $conntrol . '/' . $conntrol . '_control/update_data';
    $route['admin/' . $conntrol . '/delete_record/(:num)'] = 'admin/' . $conntrol . '/' . $conntrol . '_control/delete_record';
    $route['admin/' . $conntrol . '/tipslist/(:num)'] = 'admin/' . $conntrol . '/' . $conntrol . '_control';
    $route['admin/' . $conntrol . '/(:num)'] = 'admin/' . $conntrol . '/' . $conntrol . '_control';
    $route['admin/' . $conntrol . '/msg/(:any)'] = 'admin/' . $conntrol . '/' . $conntrol . '_control';
    $route['admin/' . $conntrol . '/unpublish_record/(:num)'] = 'admin/' . $conntrol . '/' . $conntrol . '_control/unpublish_record';
    $route['admin/' . $conntrol . '/publish_record/(:num)'] = 'admin/' . $conntrol . '/' . $conntrol . '_control/publish_record';
    $route['admin/' . $conntrol . '/load_user_detals/(:num)'] = 'admin/' . $conntrol . '/' . $conntrol . '_control/load_user_detals';
    $route['admin/' . $conntrol . '/delete_icon'] = 'admin/' . $conntrol . '/' . $conntrol . '_control/delete_icon';
    $route['admin/' . $conntrol . '/upload_image'] = 'admin/' . $conntrol . '/' . $conntrol . '_control/upload_image';
    $route['admin/' . $conntrol . '/delete_image'] = 'admin/' . $conntrol . '/' . $conntrol . '_control/delete_image';
    $route['admin/' . $conntrol . '/send_invoice/(:num)'] = 'admin/' . $conntrol . '/' . $conntrol . '_control/send_invoice';
    $route['admin/' . $conntrol . '/insert_plan_type'] = 'admin/' . $conntrol . '/' . $conntrol . '_control/insert_plan_type';
    $route['admin/' . $conntrol . '/insert_status'] = 'admin/' . $conntrol . '/' . $conntrol . '_control/insert_status';
    $route['admin/' . $conntrol . '/update_plan_type'] = 'admin/' . $conntrol . '/' . $conntrol . '_control/update_plan_type';
    $route['admin/' . $conntrol . '/update_status'] = 'admin/' . $conntrol . '/' . $conntrol . '_control/update_status';
    $route['admin/' . $conntrol . '/checkslug'] = 'admin/' . $conntrol . '/' . $conntrol . "_control" . '/checkslug';
    $route['admin/' . $conntrol . '/delete_plan_type_record/(:num)'] = 'admin/' . $conntrol . '/' . $conntrol . '_control/delete_plan_type_record';
    $route['admin/' . $conntrol . '/delete_status_record/(:num)'] = 'admin/' . $conntrol . '/' . $conntrol . '_control/delete_status_record';
    $route['admin/' . $conntrol . '/linkdelete'] = 'admin/' . $conntrol . '/' . $conntrol . '_control/link_delete';

    $route['admin/' . $conntrol . '/(:any)'] = "admin/" . $conntrol . "/" . $conntrol . "_control";
    $route['admin/' . $conntrol . '/ajax_delete_all'] = 'admin/' . $conntrol . '/' . $conntrol . '_control/ajax_delete_all';
    $route['admin/' . $conntrol . '/ajax_publish_all'] = 'admin/' . $conntrol . '/' . $conntrol . '_control/ajax_publish_all';
    $route['admin/' . $conntrol . '/ajax_unpublish_all'] = 'admin/' . $conntrol . '/' . $conntrol . '_control/ajax_unpublish_all';
    $route['admin/' . $conntrol . '/db_backup'] = 'admin/' . $conntrol . '/' . $conntrol . '_control/db_backup';
    $route['admin/' . $conntrol . '/db_restore'] = 'admin/' . $conntrol . '/' . $conntrol . '_control/db_restore';
    $route['admin/' . $conntrol . '/team_selected_check'] = 'admin/' . $conntrol . '/' . $conntrol . '_control/team_selected_check';
    $route['admin/' . $conntrol . '/selected_team'] = 'admin/' . $conntrol . '/' . $conntrol . '_control/selected_team';
    $route['admin/' . $conntrol . '/view_form/(:any)'] = 'admin/' . $conntrol . '/' . $conntrol . "_control" . '/view_form';
}
else if ($flag == 2)
{
    $route['ws/'.$conntrol . '/auto_cron'] = "ws/" . $conntrol . '/' . $conntrol . '_control/auto_cron';
}
else
{
    if ($conntrol != 'front') {
        $route[$conntrol] = "front/" . $conntrol . "/" . $conntrol . "_control";
    }
    $route[$conntrol . '/search_by_qualification'] = "front/" . $conntrol . '/' . $conntrol . '_control/search_by_qualification';
    $route[$conntrol . '/search_by_job'] = "front/" . $conntrol . '/' . $conntrol . '_control/search_by_job';
    $route[$conntrol . '/edit_record/(:num)'] = "front/" . $conntrol . "/" . $conntrol . "_control" . '/edit_record';
    $route[$conntrol . '/signup_normal'] = "front/" . $conntrol . "/" . $conntrol . "_control" . '/signup_normal';
    $route[$conntrol . '/existing_frame/(:num)'] = "front/" . $conntrol . "/" . $conntrol . "_control" . '/existing_frame';
    $route[$conntrol . '/add_record'] = "front/" . $conntrol . '/' . $conntrol . "_control" . '/add_record';
    $route[$conntrol . '/check_user'] = "front/" . $conntrol . '/' . $conntrol . "_control" . '/check_user';
    $route[$conntrol . '/add_record/(:num)'] = "front/" . $conntrol . '/' . $conntrol . "_control" . '/add_record';
    $route[$conntrol . '/my_list'] = "front/" . $conntrol . '/' . $conntrol . '_control/my_list';
    $route[$conntrol . '/send_message'] = "front/" . $conntrol . '/' . $conntrol . "_control" . '/send_message';
    if ($conntrol != 'front') {
        $route[$conntrol . '/(:any)'] = "front/" . $conntrol . "/" . $conntrol . "_control";
    }
}
//pr($route); exit;
//echo '<pre>'; print_r($route); exit;
// End
// For Front End
//echo '<pre>'; print_r($route); exit;
//For Admin Redirection
$route['index'] = "index/index";
$route['index/msg/(:any)'] = "index/index";

$route['admin'] = "admin/login/login";
$route['admin/login'] = "admin/login/login";
$route['admin/logout'] = "admin/login/logout";
$route['admin/dashboard'] = "admin/index/dashboard";

// Change Password of admin

$route['admin/change_password_view'] = "admin/change_password/change_password_control";
$route['admin/change_password/admin_change_password'] = "admin/change_password/change_password_control/admin_change_password";
$route['admin/show_time_management/ajax_screendata'] = "admin/show_time_management/show_time_management_control/ajax_screendata";
$route['admin/user_management/check_user'] = "admin/user_management/user_management_control/check_user";


//front end Login
$route['login'] = "login/login";
$route['login/login'] = "index/login/login";
$route['logout'] = "login/logout";
$route['index'] = "index/home";

$route['change_password_view'] = "change_password/change_password_control";
$route['change_password/user_change_password'] = "change_password/change_password_control/user_change_password";
