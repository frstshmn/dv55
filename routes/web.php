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

        $courses = Course::get();

        return view('dashboard',[
            'courses' => $courses,
        ]);
    });

    Route::get('/course/{id}', 'App\Http\Controllers\CourseController@show');

    Route::get('/material/{id}', 'App\Http\Controllers\MaterialController@show');
});
