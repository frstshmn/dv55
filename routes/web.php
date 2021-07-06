<?php

use App\Models\Course;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

require __DIR__.'/auth.php';

Route::group(['middleware' => 'auth'], function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    });

    Route::get('/cabinet', function () {

        $courses = Course::get();

        return view('user.cabinet',[
            'courses' => $courses,
        ]);
    });

    Route::get('/admin', function () {

        $courses = Course::get();

        return view('admin.adminpanel',[
            'courses' => $courses,
        ]);
    });

    Route::get('/courses/{id}', 'App\Http\Controllers\CourseController@show');
    //Admin
    Route::get('/courses/json/{id}', 'App\Http\Controllers\CourseController@getJSON');
    Route::post('/courses', 'App\Http\Controllers\CourseController@create');
    Route::put('/courses', 'App\Http\Controllers\CourseController@update');
    Route::delete('/courses', 'App\Http\Controllers\CourseController@delete');

    //Admin
    Route::get('/modules/{id}', 'App\Http\Controllers\ModuleController@getJSON');
    Route::get('/modules/{id}/materials', 'App\Http\Controllers\ModuleController@getMaterials');
    Route::post('/modules', 'App\Http\Controllers\ModuleController@create');
    Route::put('/modules', 'App\Http\Controllers\ModuleController@update');
    Route::delete('/modules', 'App\Http\Controllers\ModuleController@delete');

    Route::get('/materials/{id}', 'App\Http\Controllers\MaterialController@show');
    //Admin
    Route::get('/materials/json/{id}', 'App\Http\Controllers\MaterialController@getJSON');
    Route::post('/materials', 'App\Http\Controllers\MaterialController@create');
    Route::put('/materials', 'App\Http\Controllers\MaterialController@update');
    Route::delete('/materials', 'App\Http\Controllers\MaterialController@delete');

    Route::get('/tests/{id}', 'App\Http\Controllers\TestController@show');
    //Admin

    Route::get('/tests/questions/{id}', 'App\Http\Controllers\TestController@getQuestions');
    //Admin
});
