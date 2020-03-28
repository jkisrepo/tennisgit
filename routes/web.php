<?php


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use Illuminate\Support\Facades\Route;

Route::get('/forgot_password',                      'UserController@forgotPassword');
Route::post('/forgot_password',                      'UserController@forgotPasswordRequest');
// Route::get('/users/{id}/verify',                      'UserController@verifyUser');
// Route::get('/users/{id}/reset_password/{key}',      'UserController@resetPasswordForm');
// Route::post('/users/{id}/reset_password',              'UserController@resetPassword');

Route::group(['middleware' => ['web', 'auth']], function () {

    /******Admin Controller********/

    Route::get('/',                             'AdminController@dashboard');
    Route::get('/dashboard/matches',                     'AdminController@macthDashboard');
    Route::get('/dashboard/drills',                      'AdminController@drillDashboard');
    Route::get('/events',                                'AdminController@events');

    /******User Controller********/

    Route::get('/profile',                                'UserController@profile');
    Route::get('/change_password',                        'UserController@changePasswordForm');
    Route::post('/change_password',                        'UserController@changeMyPassword');
    Route::post('/profile_update',                        'UserController@profileUpdate');

    Route::group(['middleware' => ['web', 'auth.admin']], function () {
        Route::get('/users',                             'UserController@index');
        Route::post('/users',                             'UserController@index');
        Route::get('/users/create',                      'UserController@createUser');
        Route::post('/users/add',                         'UserController@newUser');
        Route::get('/users/{id}/edit',                   'UserController@editUser');
        Route::post('/users/{id}/edit',                      'UserController@updateUser');
        Route::get('/users/{id}/view',                      'UserController@viewUser');
        Route::post('/users/{id}/delete',                    'UserController@deleteUser');
        Route::get('/users/export',                        'UserController@usersExport');

        Route::get('/players/create',                         'PlayerController@playerForm');
        Route::post('/players/add',                           'PlayerController@addPlayer');
        Route::get('/players/{id}/edit',                      'PlayerController@editPlayer');
        Route::post('/players/{id}/update',                    'PlayerController@updatePlayer');
        Route::post('/players/{id}/delete',                    'PlayerController@deletePlayer');
    });

    /**Player Controller**/

    Route::get('/players',                                'PlayerController@players');
    Route::get('/players/{id}/statistics',               'PlayerController@assessmentStatistics');
    Route::get('/players/{id}/assessments/export',       'PlayerController@exportPlayersAssessments');
    Route::get('/players/export',                        'PlayerController@exportPlayers');

    //Route::group(['middleware' => ['web', 'auth.player']], function () {
    Route::get('/players/{id}/assessments',                'PlayerController@assessments');
    //});

    Route::group(['middleware' => ['web', 'auth.coach']], function () {
        Route::post('/players',                                'PlayerController@players');

        Route::get('/players/{id}/view',                      'PlayerController@viewPlayer');

        Route::post('/players/{id}/assessments',                'PlayerController@assessments');
        Route::get('/players/{id}/assessments/create',        'PlayerController@assessmentForm');
        Route::get('/players/{id}/assessments/{aid}/edit',   'PlayerController@assessmentEdit');
        Route::get('/players/{id}/assessments/{aid}/view',   'PlayerController@assessmentView');
        Route::post('/players/{id}/assessments/{aid}/delete', 'PlayerController@assessmentDelete');
    });


    Route::group(['middleware' => ['web', 'auth.admin']], function () {
        /**Academy Controller**/

        Route::post('/academies',                          'AcademyController@academies');
        Route::get('/academies/create',                  'AcademyController@academyForm');
        Route::post('/academies/add',                      'AcademyController@addAcademy');
        Route::get('/academies/{id}/edit',             'AcademyController@editAcademy');
        Route::post('/academies/{id}/update',           'AcademyController@updateAcademy');
        Route::post('/academies/{id}/delete',           'AcademyController@deleteAcademy');
        Route::get('/academies/{id}/view',             'AcademyController@viewAcademy');
        Route::get('/academies/{id}/coaches',          'AcademyController@academyCoaches');
        Route::post('/academies/{id}/coaches',          'AcademyController@academyCoaches');
        Route::get('/academies/{id}/coaches/assign',   'AcademyController@academyCoachesAssignFrom');
        Route::post('/academies/{id}/coaches/add',      'AcademyController@academyCoachesAdd');
        Route::get('/academies/coaches/{id}/delete',   'AcademyController@academyCoachDelete');
        Route::get('/academies/{id}/players',          'AcademyController@academyPlayers');
        Route::post('/academies/{id}/players',          'AcademyController@academyPlayers');
        Route::get('/academies/export',                'AcademyController@academiesExport');
        Route::get('/academies/{id}/coaches/export',   'AcademyController@academyCoachesExport');
        Route::get('/academies/{id}/players/export',   'AcademyController@academyPlayersExport');
    });

    /**Schedule Controller**/

    Route::get('/schedules',                             'ScheduleController@schedules');
    Route::post('/schedules',                             'ScheduleController@schedules');
    Route::get('/schedules/export',                    'ScheduleController@schedulesExport');

    Route::group(['middleware' => ['web', 'auth.coach']], function () {
        Route::get('/academies',                              'AcademyController@academies');
        Route::get('/schedules/create',                     'ScheduleController@scheduleFrom');
        Route::post('/schedules/add',                         'ScheduleController@addMatchSchedule');
        Route::post('/schedules/{id}/delete',                 'ScheduleController@deleteMatchSchedule');
        Route::get('/schedules/{id}/edit',                 'ScheduleController@editMatchSchedule');
        Route::post('/schedules/{id}/update',                 'ScheduleController@updateMatchSchedule');
        Route::post('/schedules/{id}/winner',                  'ScheduleController@updateMatchWinner');
    });

    //Route::group(['middleware' => ['web', 'auth.player']], function () {
    Route::get('/schedules/{id}/view',                 'ScheduleController@viewMatchSchedule');
    //});

    /**Assessment Controller**/

    Route::group(['middleware' => ['web', 'auth.coach']], function () {
        Route::post('/assessments/{id}/update',              'AssessmentController@updateAssessment');
        Route::post('/assessments',                          'AssessmentController@addAssessment');
        Route::get('/playerscoach',                           'AssessmentController@getCoachPlayersByMatch');
    });

    /***Attendance Controller***/
    Route::group([/*'middleware' => ['web', 'auth.player'],*/'role' => 'attendance'], function () {
        Route::get('/attendance/players',                   'AttendanceController@playerAttendance');
        Route::get('/attendance/players/{id}/graph',         'AttendanceController@playerAttendanceGraph');
    });
    Route::get('/attendance/player_attendance/export',  'AttendanceController@playerAttendanceExport');


    Route::group(['middleware' => ['web', 'auth.coach'], 'role' => 'attendance'], function () {
        Route::get('/attendance/{id}/players/edit',            'AttendanceController@editPlayerAttendance');
        Route::post('/attendance/{id}/players/',                'AttendanceController@updatePlayerAttendance');
        Route::post('/attendance/{id}/players/delete',       'AttendanceController@deletePlayerAttendance');
        Route::post('/attendance/players',                   'AttendanceController@playerAttendance');
        Route::get('/attendance/players/create',            'AttendanceController@formPlayerAttendance');
        Route::post('/attendance/players/add',               'AttendanceController@addPlayerAttendance');
        Route::get('/attendance/coaches',                   'AttendanceController@coachAttendance');
        Route::post('/attendance/coaches',                   'AttendanceController@coachAttendance');
        Route::get('/attendance/coaches/create',            'AttendanceController@formCoachAttendance');
        Route::post('/attendance/coaches/add',               'AttendanceController@addCoachAttendance');
        Route::get('/attendance/coach_attendance/export',   'AttendanceController@coachAttendanceExport');
        Route::get('attendance/coaches/{id}/graph',         'AttendanceController@coachAttendanceGraph');
    });

    Route::match(['get', 'post'], '/feedback', 'AdminController@feedback');


    //Route::group(['middleware' => ['web', 'auth.player']], function () {
    Route::get('/attendance/{id}/players/view',            'AttendanceController@viewPlayerAttendance');
    //});


    /************drills Controller*****************/
    Route::group(['middleware' => ['web', 'auth.admin']], function () {

        Route::get('/attendance/{id}/coaches/edit',            'AttendanceController@editCoachAttendance');
        Route::post('/attendance/{id}/coaches/',                'AttendanceController@updateCoachAttendance');
        Route::get('/attendance/{id}/coaches/view',            'AttendanceController@viewCoachAttendance');
        Route::post('/attendance/{id}/coaches/delete',       'AttendanceController@deleteCoachAttendance');
        Route::get('/drills',                               'DrillsController@drills');
        Route::post('/drills',                               'DrillsController@drills');
        Route::get('/drills/create',                        'DrillsController@drillsForm');
        Route::post('/drills/add',                           'DrillsController@addDrills');
        Route::get('/drills/{id}/edit',                     'DrillsController@editDrills');
        Route::post('/drills/{id}/edit',                     'DrillsController@updateDrills');
        Route::post('/drills/{id}/delete',                   'DrillsController@deleteDrills');
        Route::get('/drills/{id}/view',                     'DrillsController@viewDrills');
        Route::get('/drills/export',                           'DrillsController@drillsExport');
        Route::post('/drills/image/{id}/delete',             'DrillsController@DrillsImageDelete');
    });
    Route::group(['middleware' => ['web', 'auth.coach']], function () {
        Route::get('/drills/assign',                        'DrillsController@assignDrills');
        Route::post('/drills/assign',                        'DrillsController@addAssignDrills');
    });

    //Route::group(['middleware' => ['web', 'auth.player']], function () {
    Route::get('/drills/assign/{id}/view', 'DrillsController@viewAssignDrills');
    //});
});





Route::get('/error', function () {

    return view('errors.503');
});
Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');