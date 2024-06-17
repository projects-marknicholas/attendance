<?php
// Security Headers
function cors() {
  if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');
  }

  if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
      header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    }
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
      header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    }
    exit(0);
  }
}

cors();

require 'config.php';
require 'router.php';
require 'controllers/auth.php';
require 'controllers/admin.php';

// Initialize Router
$router = new Router();

// Post Requests
$router->post('/api/auth/login', 'AuthController@login');
$router->post('/api/v1/course', 'AdminController@course');
$router->post('/api/v1/subject', 'AdminController@subject');
$router->post('/api/v1/faculty', 'AdminController@faculty');
$router->post('/api/v1/class', 'AdminController@class');
$router->post('/api/v1/students', 'AdminController@students');
$router->post('/api/v1/attendance', 'AdminController@attendance');

// Get Requests
$router->get('/api/v1/course', 'AdminController@fetch_course');
$router->get('/api/v1/subject', 'AdminController@fetch_subject');
$router->get('/api/v1/all-subject', 'AdminController@fetch_all_subject');
$router->get('/api/v1/subject-id', 'AdminController@fetch_subject_id');
$router->get('/api/v1/faculty', 'AdminController@fetch_faculty');
$router->get('/api/v1/class', 'AdminController@fetch_class');
$router->get('/api/v1/students', 'AdminController@fetch_students');
$router->get('/api/v1/attendance', 'AdminController@fetch_attendance');
$router->get('/api/v1/view-attendance', 'AdminController@fetch_view_attendance');

// Put Requests
$router->post('/api/v1/put_course', 'AdminController@put_course');
$router->post('/api/v1/put_subject', 'AdminController@put_subject');
$router->post('/api/v1/put_faculty', 'AdminController@put_faculty');
$router->post('/api/v1/put_students', 'AdminController@put_students');

// Delete Requests
$router->delete('/api/v1/course', 'AdminController@delete_course');
$router->delete('/api/v1/subject', 'AdminController@delete_subject');
$router->delete('/api/v1/faculty', 'AdminController@delete_faculty');
$router->delete('/api/v1/class', 'AdminController@delete_class');
$router->delete('/api/v1/students', 'AdminController@delete_students');
$router->delete('/api/v1/attendance', 'AdminController@delete_attendance');

// Dispatch the request
$router->dispatch();
?>
