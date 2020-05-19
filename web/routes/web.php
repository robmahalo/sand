<?php

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

// Route::get("/", "StudentController@index");

use App\Http\Controllers\RequestController;

Route::get('/', function () {
    return view('login');
});

Route::get('/sand-signup-student', function () {
    return view('signup_students');
});

Route::get('/sand-signup-tutor', function () {
    return view('signup_tutor')
    ->with("courses", (new RequestController())->getAllCourses());
});

Route::get('/logout', function () {
    session()->remove("role");
    return view('logout');
});

Route::get("sand-students", "StudentController@index");
Route::get("sand-tutors", "TutorController@index");
Route::get("sand-subjects", "SubjectController@index");
Route::get("sand-requests", "RequestController@index");
Route::get("sand-profile", "ProfileController@index");
Route::get("sand-edit-profile", "ProfileController@edit");
Route::get("sand-schedule", "RequestController@getSchedule");

Route::post('dashboard', 'DashboardController@index');
Route::post("students", "StudentController@store");
Route::post("create-student", "StudentController@create");
Route::post("tutors", "TutorController@store");
Route::post("create-tutor", "TutorController@create");
Route::post("tutor_course", "SubjectController@storeTutorCourse");
Route::post("student_course", "SubjectController@storeStudentCourse");
Route::post("requests", "RequestController@store");
Route::post("edit-tutor", "TutorController@edit");
Route::post("edit-student", "StudentController@edit");
