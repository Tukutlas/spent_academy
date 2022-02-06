<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$auth = [
    'prefix'    => 'auth',
    'namespace' => 'Auth'
];


$router->group($auth, function () use ($router) {
    $router->post('/register', 'Register@register');
    // $router->get('/activate/{token}', 'Activate@index');
    // $router->post('/resend-activation', 'Activate@resend');
    $router->post('/login', 'Login@index');
    // $router->post('/forgot-password', 'ForgotPassword@index');
    // $router->post('/reset/{token}', 'Reset@resetPassword');
    // $router->get('/reset/{token}', 'Reset@index');
    $router->post('/logout', 'Logout@index');
});

$course = [   
    'namespace' => 'Instructor',
    'middleware' => 'token_auth',
    'prefix'    => 'course',
];

$router->group($course, function () use ($router) {
    $router->get('/get/{id}', 'Courses@getCourse');
    $router->post('/create', 'Courses@createCourse');
});

$admin = [
    'namespace' => 'Admin',
    'middleware' => 'token_auth',
    'prefix'    => 'admin',
];

$router->group($admin, function () use ($router){
    $router->get('/get-course-categories', 'Courses@getCourseCategories');
    $router->get('/get-course-subcategories', 'Courses@getCourseSubcategories');
    $router->get('/get-course-subcategories-by-category/{id}', 'Courses@getCourseSubcategoriesByCategory');

    $router->post('/create-course-category', 'Courses@createCourseCategory');
    $router->post('/create-course-subcategory', 'Courses@createCourseSubcategory');
});