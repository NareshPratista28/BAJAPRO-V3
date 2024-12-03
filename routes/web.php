<?php

use App\Http\Controllers\Admin\DashboardController;
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

Route::get('/', [App\Http\Controllers\HomeController::class, "index"])->name("home");

Route::prefix('api')->middleware('api')->as('api.');

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth', 'admin'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    // Route::get("/", [App\Http\Controllers\Admin\DashboardController::class, "index"])->name("dashboard");
    Route::get("/", [App\Http\Controllers\Admin\DashboardController::class, "leaderboard"])->name("leaderboard");
    Route::resource('roles', App\Http\Controllers\Admin\RoleController::class);
    Route::resource('courses', App\Http\Controllers\Admin\CourseController::class);
    Route::resource('lessons', App\Http\Controllers\Admin\LessonController::class);
    Route::resource('contents', App\Http\Controllers\Admin\ContentController::class);
    Route::resource('questions', App\Http\Controllers\Admin\QuestionController::class);
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    Route::resource('badgeSettings', \App\Http\Controllers\Admin\BadgeSettingController::class);
    Route::resource('level', App\Http\Controllers\Admin\LevelController::class);
    Route::resource('explaination', App\Http\Controllers\Admin\ExplanationController::class);
    Route::put('/update/code/explaination/{id}', [App\Http\Controllers\Admin\ExplanationController::class, "updateCode"])->name('code.update.explanation');
    Route::get('/code/explaination', [App\Http\Controllers\Admin\ExplanationController::class, "showCode"])->name('code.index.explanation');
    Route::get('/edit/code/explaination/{id}', [App\Http\Controllers\Admin\ExplanationController::class, "editCode"])->name('code.edit.explanation');
    Route::get("/report/{user_id?}", [\App\Http\Controllers\Admin\DashboardController::class, "report"])->name("dashboard.report");
    Route::get("/penilaian/{user_id}/{content_id}", [\App\Http\Controllers\Admin\DashboardController::class, "penilaian"])->name("dashboard.penilaian");
    Route::post("/create/penilaian", [\App\Http\Controllers\Admin\DashboardController::class, "addPenilaian"])->name("dashboard.add.penilaian");
});

Route::group(['middleware' => ["auth"]], function () {
    //leaderboard
    Route::get("/courses/leaderboard", [App\Http\Controllers\Admin\DashboardController::class, "leaderboard"])->name("student_course.leaderboard");

    Route::get("/courses/my_course", [\App\Http\Controllers\StudentCourseController::class, "index"])->name("student_course.my_course");
    Route::post("/take_course", [\App\Http\Controllers\StudentCourseController::class, "takeCourse"])->name("student_course.take");
    Route::get("/courses/my_course/{course_id}/{level_id}", [\App\Http\Controllers\StudentCourseController::class, "my_course"])->name("student_course.my_course.detail");
    Route::get("/courses/my_course/{course_id}/{level_id}/detail/{content_id?}", [\App\Http\Controllers\StudentCourseController::class, "my_course"])->name("student_course.my_course.detail.content");
    Route::get("/courses/detail/{course_id}", [\App\Http\Controllers\StudentCourseController::class, "detail"])->name("student_course.detail");
    Route::get("/courses/code_test/{question_id}", [\App\Http\Controllers\CodeTestController::class, "index"])->name("code_test");
    Route::post("/courses/code_test/{question_id}/submit", [\App\Http\Controllers\CodeTestController::class, "codeTestSubmit"])->name("code_test.submit");
    Route::get("/courses/report", [\App\Http\Controllers\StudentCourseController::class, "report"])->name("student_course.report");
    Route::get("/courses/level/{course_id}", [\App\Http\Controllers\StudentCourseController::class, "level"])->name("student_course.level");
    Route::get("/courses/report/detail/{question_id}", [\App\Http\Controllers\StudentCourseController::class, "detailReport"])->name("student_course.report.detail");
    Route::post("/courses/explain/{level_id}", [\App\Http\Controllers\ExplainingController::class, "create"])->name("student_course.explain");

    //wondering
    Route::post("/courses/read/score", [\App\Http\Controllers\StudentCourseController::class, "readScore"])->name("student_course.read.score");


    Route::get("/explain", [\App\Http\Controllers\ExplainingController::class, "show"])->name("student_course.show.explain");
    Route::get("/explain/code", [\App\Http\Controllers\ExplainingController::class, "showCode"])->name("student_course.show.explain.code");
    Route::get("/essay/edit/{id}", [\App\Http\Controllers\ExplainingController::class, "editEssay"])->name("student_course.essay.edit");
    Route::put("/essay/update/{id}", [\App\Http\Controllers\ExplainingController::class, "updateEssay"])->name("essay.update");

    Route::get("/explain/edit/{id}", [\App\Http\Controllers\ExplainingController::class, "edit"])->name('student_course.edit.explain');
    Route::get("/explain/code/edit/{id}", [\App\Http\Controllers\ExplainingController::class, "editCode"])->name('student_course.code.edit.explain');
    Route::put("/explain/update/{id}/{title}", [\App\Http\Controllers\ExplainingController::class, "update"])->name("student_course.update.explain");
    Route::get("/table/explain", [\App\Http\Controllers\ExplainingController::class, "tableExplain"])->name("table.explain");
});

Route::get('generator_builder', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@builder')->name('io_generator_builder');

Route::get('field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@fieldTemplate')->name('io_field_template');

Route::get('relation_field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@relationFieldTemplate')->name('io_relation_field_template');

Route::post('generator_builder/generate', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generate')->name('io_generator_builder_generate');

Route::post('generator_builder/rollback', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@rollback')->name('io_generator_builder_rollback');

Route::post(
    'generator_builder/generate-from-file',
    '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generateFromFile'
)->name('io_generator_builder_generate_from_file');
