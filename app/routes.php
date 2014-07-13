<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::group(['namespace' => 'eTrack\Controllers'], function ()
{
    Route::get('user/login', ['as' => 'login', 'uses' => 'UserController@login']);
    Route::post('user/login', ['as' => 'auth', 'uses' => 'UserController@authenticate']);
    Route::get('user/logout', ['as' => 'logout', 'uses' => 'UserController@logout']);
});

Route::group(['before' => 'auth', 'namespace' => 'eTrack\Controllers'], function ()
{
    Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
    Route::resource('profile', 'ProfileController', array('only' => array('index', 'store')));
});

Route::group(['before' => 'auth|admin', 'prefix' => 'admin', 'namespace' => 'eTrack\Controllers\Admin'], function ()
{
    Route::get('users/delete/{id}', ['as' => 'admin.users.delete_confirm', 'uses' => 'UserController@deleteConfirm']);
    Route::get('users/import', ['as' => 'admin.users.import.step1', 'uses' => 'UserController@importStep1']);
    Route::post('users/import', ['as' => 'admin.users.import.step1.store', 'uses' => 'UserController@importStep1Store']);
    Route::get('users/import/step2', ['as' => 'admin.users.import.step2', 'uses' => 'UserController@importStep2']);
    Route::post('users/import/step2', ['as' => 'admin.users.import.step2.store', 'uses' => 'UserController@importStep2Store']);
    Route::get('users/import/step3', ['as' => 'admin.users.import.step3', 'uses' => 'UserController@importStep3']);
    Route::post('users/import/step3', ['as' => 'admin.users.import.step3.store', 'uses' => 'UserController@importStep3Store']);
    Route::get('users/import/print', ['as' => 'admin.users.import.print', 'uses' => 'UserController@importPrint']);
    Route::resource('users', 'UserController');

    Route::get('faculties/delete/{id}', ['as' => 'admin.faculties.delete_confirm', 'uses' => 'FacultyController@deleteConfirm']);
    Route::resource('faculties', 'FacultyController');

    Route::get('subjectsectors/delete/{id}', ['as' => 'admin.subjectsectors.delete_confirm', 'uses' => 'SubjectSectorController@deleteConfirm']);
    Route::resource('subjectsectors', 'SubjectSectorController');

    Route::get('courses/delete/{id}', ['as' => 'admin.courses.delete_confirm', 'uses' => 'CourseController@deleteConfirm']);
    Route::resource('courses', 'CourseController');

    Route::get('courses/{courseId}/units/delete/{id}', ['as' => 'admin.courses.units.delete_confirm', 'uses' => 'CourseUnitController@deleteConfirm']);
    Route::get('courses/{courseId}/units/add', ['as' => 'admin.courses.units.add', 'uses' => 'CourseUnitController@add']);
    Route::resource('courses.units', 'CourseUnitController', ['except' => ['index', 'create', 'edit', 'update']]);

    Route::get('courses/{courseId}/students/add', ['as' => 'admin.courses.students.add', 'uses' => 'CourseStudentController@add']);
    Route::get('courses/{courseId}/students/delete/{id}', ['as' => 'admin.courses.students.delete_confirm', 'uses' => 'CourseStudentController@deleteConfirm']);
    Route::resource('courses.students', 'CourseStudentController', ['except' => ['index', 'create']]);

    Route::get('courses/{courseId}/units/{unitId}/assignments/delete/{id}', ['as' => 'admin.courses.units.assignments.delete_confirm', 'uses' => 'AssignmentController@deleteConfirm']);
    Route::resource('courses.units.assignments', 'AssignmentController', ['except' => ['index']]);

    Route::get('courses/{courseId}/units/{unitId}/assignments/{assignmentId}/submissions/delete/{id}', [
        'as' => 'admin.courses.units.assignments.submissions.delete_confirm',
        'uses' => 'StudentSubmissionController@deleteConfirm'
    ]);
    Route::get('courses/{courseId}/units/{unitId}/assignments/{assignmentId}/submissions/add', [
        'as' => 'admin.courses.units.assignments.submissions.add',
        'uses' => 'StudentSubmissionController@add'
    ]);
    Route::resource('courses.units.assignments.submissions', 'StudentSubmissionController', [
        'except' => ['index', 'create']
    ]);

    Route::get('courses/{courseId}/units/{unitId}/assignments/{assignmentId}/submissions/{studentId}/assess', [
        'as' => 'admin.courses.units.assignments.submissions.assess',
        'uses' => 'StudentAssessmentController@index'
    ]);

    Route::get('courses/{courseId}/students/delete/{id}', ['as' => 'admin.courses.student_groups.delete_confirm', 'uses' => 'StudentGroupController@deleteConfirm']);
    Route::resource('courses.student_groups', 'StudentGroupController');

    Route::get('courses/{courseId}/tracker', ['as' => 'admin.courses.tracker.index', 'uses' => 'CourseTrackerController@index']);
    Route::get('courses/{courseId}/tracker/finalcalc', ['as' => 'admin.courses.tracker.final_calc', 'uses' => 'CourseTrackerController@calculateFinal']);
    Route::get('courses/{courseId}/tracker/{unitId}', ['as' => 'admin.courses.tracker.unit', 'uses' => 'CourseTrackerController@unit']);

    Route::get('units/delete/{id}', ['as' => 'admin.units.delete_confirm', 'uses' => 'UnitController@deleteConfirm']);
    Route::resource('units', 'UnitController');
});

App::missing(function()
{
    return Response::view('errors.404', [], 404);
});
