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
$route['default_controller'] = 'admin';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['admin/change-password'] = 'admin/change_password';
$route['admin/profile'] = 'admin/profile';
$route['admin/settings'] = 'admin/settings';
$route['admin/faq'] = 'admin/faq';
$route['admin/forgot-password'] = 'admin/forgot_password';
$route['admin/account'] = 'admin/accountListing';
$route['admin/account/change_account_status/(:any)/(:any)'] = 'admin/change_account_status/$1/$2';
$route['admin/library'] = 'admin/libraryListing';
$route['admin/library/view/(:any)'] = 'admin/viewLibrary/$1';

//Forgot Password
$route['user/password-reset/(:any)/(:any)'] = "Api/password_reset/$1/$2";

//University Management
$route['admin/university'] = 'University/index';
$route['admin/add-university'] = 'University/addUniversity';
$route['admin/edit-university/(:any)'] = 'University/addUniversity/$1';

//Notification Management
$route['admin/notification'] = 'Notification/index';
$route['admin/view-user-notification/(:any)'] = 'Notification/view_user_notification/$1';
$route['admin/do-send-notification'] = "Notification/do_send_notification";

//Job Management
$route['admin/job'] = 'Job/index';
$route['admin/add-job'] = 'Job/addJob';
$route['admin/edit-job/(:any)'] = 'Job/addJob/$1';
$route['admin/job/change_job_status/(:any)/(:any)'] = 'Job/change_job_status/$1/$2';

//Job Request Management
$route['admin/job_request'] = 'Job/jobRequest';

//Category Management
$route['admin/category'] = 'Category/index';
$route['admin/category/(:any)'] = 'Category/index/$1';
$route['admin/get-category-wrapper'] = 'Category/get_category_wrapper';
$route['admin/do-edit-category/(:any)'] = "admin/Category/do_edit_category/$1";
$route['admin/category/change_category_status/(:any)/(:any)'] = 'Category/change_category_status/$1/$2';

//Experience Management
$route['admin/experience'] = 'Experience/index';
$route['admin/experience/(:any)'] = 'Experience/index/$1';
$route['admin/get-experience-wrapper'] = 'Experience/get_experience_wrapper';
$route['admin/experience/change_experience_status/(:any)/(:any)'] = 'Experience/change_experience_status/$1/$2';

//Industry Type Management
$route['admin/industry'] = 'Experience/industry';
$route['admin/industry/(:any)'] = 'Experience/industry/$1';
$route['admin/get-industry-wrapper'] = 'Experience/get_industry_wrapper';
$route['admin/industry/change_industry_status/(:any)/(:any)'] = 'Experience/change_industry_status/$1/$2';
//Study Type Management
$route['admin/study'] = 'Experience/study';
$route['admin/study/(:any)'] = 'Experience/study/$1';
$route['admin/get_study_wrapper'] = 'Experience/get_study_wrapper';
$route['admin/study/change_study_status/(:any)/(:any)'] = 'Experience/change_study_status/$1/$2';


//Employee Type Management
$route['admin/employee'] = 'Experience/employee';
$route['admin/employee/(:any)'] = 'Experience/employee/$1';
$route['admin/get-employee-wrapper'] = 'Experience/get_employee_wrapper';
$route['admin/employee/change_employee_status/(:any)/(:any)'] = 'Experience/change_employee_status/$1/$2';

//Banner Management
$route['admin/get-banner-wrapper'] = 'Admin/get_banner_wrapper';

//Walkthrough Management
$route['admin/walkthrough/(:any)'] = 'Admin/walkthrough/$1';

//Courses Management
$route['admin/course'] = 'Category/course';
$route['admin/course/(:any)'] = 'Category/course/$1';
$route['admin/get-course-wrapper'] = 'Category/get_course_wrapper';
$route['admin/do-edit-course/(:any)'] = "admin/Category/do_edit_course/$1";
$route['admin/course/change_course_status/(:any)/(:any)'] = 'Category/change_course_status/$1/$2';
