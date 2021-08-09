<?php

use App\Models\Course;
use App\Models\UserCourses;
use App\Models\User;
use App\Models\Test;

use Illuminate\Support\Facades\Auth;
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
    $courses = Course::get();
    return view('welcome',[
        'courses' => $courses,
    ]);
})->name('landing');

Route::post('/sendmail', 'App\Http\Controllers\UserController@sendMail');

require __DIR__.'/auth.php';

Route::group(['middleware' => 'auth'], function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    });


// User dashboard
    Route::get('/cabinet', function () {

        $courses = UserCourses::where('user_id', Auth::user()->id)->get();
        return view('user.cabinet',[
            'courses' => $courses,
        ]);

    });



// Admin dashboard
    Route::get('/admin', function () {
        $users = User::get();
        $courses = Course::get();
        return view('admin.adminpanel',[
            'users' => $users,
            'courses' => $courses,
        ]);
    });

    Route::get('/tests', function () {
        $users = User::get();
        $courses = Course::get();
        $tests = Test::get();
        return view('admin.testpanel',[
            'users' => $users,
            'courses' => $courses,
            'tests' => $tests,
        ]);
    });

    Route::get('/users', function () {
        $users = User::get();
        $courses = Course::get();
        return view('admin.userpanel',[
            'users' => $users,
            'courses' => $courses,
        ]);
    });



// Entity routes
    Route::get('/courses/{id}', 'App\Http\Controllers\CourseController@show');
    //Admin
    Route::get('/courses/json/{id}', 'App\Http\Controllers\CourseController@getJSON');
    Route::post('/courses', 'App\Http\Controllers\CourseController@create');
    Route::put('/courses', 'App\Http\Controllers\CourseController@update');
    Route::delete('/courses', 'App\Http\Controllers\CourseController@delete');

    Route::post('/courses/sidebar/module', 'App\Http\Controllers\CourseController@getModule');
    Route::post('/courses/sidebar/total', 'App\Http\Controllers\CourseController@getTotal');


    //Admin
    Route::get('/modules/json/{id}', 'App\Http\Controllers\ModuleController@getJSON');
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
    Route::get('/tests/questions/{id}', 'App\Http\Controllers\TestController@getQuestions');
    //Admin
    Route::get('/tests/json/{id}', 'App\Http\Controllers\TestController@getJSON');
    Route::post('/tests', 'App\Http\Controllers\TestController@create');
    Route::put('/tests', 'App\Http\Controllers\TestController@update');
    Route::delete('/tests', 'App\Http\Controllers\TestController@delete');



    //Admin
    Route::get('/questions/json/{id}', 'App\Http\Controllers\QuestionController@getJSON');
    Route::delete('/questions', 'App\Http\Controllers\QuestionController@delete');



    //Admin
    Route::get('/users/json/{id}', 'App\Http\Controllers\UserController@getJSON');
    Route::get('/users/json/{id}/courses', 'App\Http\Controllers\UserController@getCourses');
    Route::post('/users', 'App\Http\Controllers\UserController@create');
    Route::put('/users', 'App\Http\Controllers\UserController@update');
    Route::delete('/users', 'App\Http\Controllers\UserController@delete');

    //Admin
    Route::post('/usercourses', 'App\Http\Controllers\UserCoursesController@create');
    Route::delete('/usercourses', 'App\Http\Controllers\UserCoursesController@delete');

    Route::post('/usercomplection', 'App\Http\Controllers\UserComplectionController@create');
    //Admin

    Route::post('/answers', 'App\Http\Controllers\AnswerController@create');
    Route::get('/results', 'App\Http\Controllers\AnswerController@showResults')->name('results');
});
