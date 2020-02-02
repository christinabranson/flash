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

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();

// Admin Routes
Route::group(['middleware' => 'auth'], function () {
    Route::get('/manage/courses', 'CourseController@browse')->name('courses.browse');
    Route::get('/manage/courses/view/{id}', 'CourseController@read', function ($id){return $id;})->name('courses.view');
    Route::get('/manage/courses/add', 'CourseController@add')->name('courses.add');
    Route::get('/manage/courses/edit/{id}', 'CourseController@edit', function ($id){return $id;})->name('courses.edit');
    Route::post('/manage/courses/save', 'CourseController@save')->name('courses.save');
    Route::get('/manage/courses/delete/{id}', 'CourseController@delete', function ($id){return $id;})->name('courses.delete');
    Route::post('/manage/courses/delete', 'CourseController@delete')->name('courses.delete_confirm');

    // Section questions
    Route::get('/manage/courses/section_questions/{id}', 'CourseController@manage_section_questions', function ($id){return $id;})->name('courses.manage_section_questions');
    Route::get('/manage/courses/questions/{id}', 'CourseController@manage_questions', function ($id){return $id;})->name('courses.manage_course_questions');
    Route::post('/manage/courses/questions_save', 'CourseController@save_questions')->name('courses.save_questions');
    Route::post('/manage/courses/ajax_submit_question_for_id', 'CourseController@ajax_submit_question_for_id')->name('courses.ajax_submit_question_for_id');

    // Take quiz
    Route::get('/quiz/course/{id}', 'QuizController@take_course_quiz', function ($id){return $id;})->name('quiz.take_course_quiz');
    Route::get('/quiz/section/{id}', 'QuizController@take_course_section_quiz', function ($id){return $id;})->name('quiz.take_course_section_quiz');
    Route::get('/quiz/next', 'QuizController@next_question')->name('quiz.next_question');
    Route::post('/quiz/submit', 'QuizController@submit')->name('quiz.submit');
    Route::get('/quiz/results', 'QuizController@results')->name('quiz.results');

    // Reporting & history
    Route::get('/history', 'HistoryController@index')->name('history.index');


});



Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
	Route::get('table-list', function () {
		return view('pages.table_list');
	})->name('table');

	Route::get('typography', function () {
		return view('pages.typography');
	})->name('typography');

	Route::get('icons', function () {
		return view('pages.icons');
	})->name('icons');

	Route::get('map', function () {
		return view('pages.map');
	})->name('map');

	Route::get('notifications', function () {
		return view('pages.notifications');
	})->name('notifications');

	Route::get('rtl-support', function () {
		return view('pages.language');
	})->name('language');

	Route::get('upgrade', function () {
		return view('pages.upgrade');
	})->name('upgrade');
});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});

