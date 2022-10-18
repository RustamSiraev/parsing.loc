<?php

use App\Http\Controllers\Admin\ApplicantController;
use App\Http\Controllers\Admin\CollegeController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\Select2SearchController;
use App\Http\Controllers\Admin\SpecialityController;
use App\Http\Controllers\Admin\StatementsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Applicant\StatementController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SignupController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
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

Route::middleware('web')->group(function () {
    // главная
    Route::get('/', [SignupController::class, 'index'])->name('index');
    // новости
    Route::get('/news', [HomeController::class, 'news'])->name('news');
    Route::get('/news/{id}', [HomeController::class, 'show'])->name('news.show');
    // форма регистрации
    Route::get('register', [SignupController::class, 'register'])->name('register');
    // создание пользователя
    Route::post('register', [SignupController::class, 'create'])->name('create');
    // форма входа
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    // аутентификация
    Route::post('login', [LoginController::class, 'login']);
    // выход
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    // смена пароля
    Route::get('password', [SignupController::class, 'password'])->name('password');
    // сброс пароля
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');


Route::middleware('auth')->group(function () {

    // Супер-админ
    Route::group(['middleware' => 'role:root'], function() {
        Route::prefix('admin')->group(function () {
            // Пользователи
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/users', [UserController::class, 'users'])->name('users.index');
            Route::get('/users/list', [UserController::class, 'getUsers'])->name('users.list');
            Route::get('/users/{user}/activity', [UserController::class, 'activity'])->name('users.activity');
            Route::get('/users/{user}/password', [UserController::class, 'password'])->name('users.password');
            Route::get('/users/{user}/login', [UserController::class, 'login'])->name('users.login');
            Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
            Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
            Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
            Route::get('/users/{user}/show', [UserController::class, 'show'])->name('users.show');
            Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
            Route::get('/deleteUser', [UserController::class, 'deleteUser']);
            Route::get('/users/{snapshot}/snapshot', [UserController::class, 'snapshot'])->name('users.snapshot');
            // Специальности
            Route::get('/specialities', [SpecialityController::class, 'index'])->name('specialities.index');
            Route::get('/specialities/list', [SpecialityController::class, 'getSpecialities'])->name('specialities.list');
            // Абитуриенты
            Route::get('/applicants/list', [ApplicantController::class, 'getApplicant'])->name('applicants.list');
            Route::resource('applicants', ApplicantController::class);
            Route::get('/applicants/{applicant}/password', [ApplicantController::class, 'password'])->name('applicants.password');
            Route::get('/applicants/{user}/activity', [ApplicantController::class, 'activity'])->name('applicants.activity');
            Route::get('/applicants/{snapshot}/snapshot', [ApplicantController::class, 'snapshot'])->name('applicants.snapshot');
            // СПО
            Route::get('/colleges/list', [CollegeController::class, 'getColleges'])->name('colleges.list');
            Route::resource('colleges', CollegeController::class);
            //Заявления
            Route::get('/statements', [StatementsController::class, 'index'])->name('statements.index');
            Route::get('/statements/list', [StatementsController::class, 'getStatements'])->name('statements.list');
            Route::get('/statements/{statement}/show', [\App\Http\Controllers\College\StatementController::class, 'show'])->name('statements.show');
            //Новости
            Route::get('/news', [NewsController::class, 'index'])->name('admin.news');
            Route::get('/news/list', [NewsController::class, 'getNews'])->name('admin.news.list');
            Route::get('/news/create', [NewsController::class, 'create'])->name('admin.news.create');
            Route::get('/news/{news}/edit', [NewsController::class, 'edit'])->name('admin.news.edit');
            Route::post('/news/store', [NewsController::class, 'store'])->name('admin.news.store');
            Route::put('/news/{news}', [NewsController::class, 'update'])->name('admin.news.update');
            Route::get('deleteNews', [NewsController::class, 'deleteNews']);
            //Статистика
            Route::get('/statistic', [ReportController::class, 'index'])->name('statistic.index');
            Route::get('/statistic/list', [ReportController::class, 'getStatistics'])->name('statistic.list');
        });
    });

    // Учебное заведение
    Route::prefix('college')->group(function () {
        Route::group(['middleware' => 'role:admin'], function() {
            // Пользователи
            Route::get('/users', [\App\Http\Controllers\College\UserController::class, 'users'])->name('college.users.index');
            Route::get('/users/list', [\App\Http\Controllers\College\UserController::class, 'getUsers'])->name('college.users.list');
            Route::get('/users/{user}/activity', [\App\Http\Controllers\College\UserController::class, 'activity'])->name('college.users.activity');
            Route::get('/users/{user}/password', [\App\Http\Controllers\College\UserController::class, 'password'])->name('college.users.password');
            Route::get('/users/{user}/login', [\App\Http\Controllers\College\UserController::class, 'login'])->name('college.users.login');
            Route::get('/users/create', [\App\Http\Controllers\College\UserController::class, 'create'])->name('college.users.create');
            Route::post('/users/store', [\App\Http\Controllers\College\UserController::class, 'store'])->name('college.users.store');
            Route::get('/users/{user}/edit', [\App\Http\Controllers\College\UserController::class, 'edit'])->name('college.users.edit');
            Route::get('/users/{user}/show', [\App\Http\Controllers\College\UserController::class, 'show'])->name('college.users.show');
            Route::put('/users/{user}', [\App\Http\Controllers\College\UserController::class, 'update'])->name('college.users.update');
            Route::get('/deleteUser', [\App\Http\Controllers\College\UserController::class, 'deleteUser']);
            Route::get('/users/{snapshot}/snapshot', [\App\Http\Controllers\College\UserController::class, 'snapshot'])->name('college.users.snapshot');

            // Абитуриенты
            Route::get('/applicants', [\App\Http\Controllers\College\ApplicantController::class, 'index'])->name('college.applicants');
            Route::get('/applicants/list', [\App\Http\Controllers\College\ApplicantController::class, 'getApplicant'])->name('college.applicants.list');
            Route::get('/applicants/create', [\App\Http\Controllers\College\ApplicantController::class, 'create'])->name('college.applicants.create');
            Route::post('/applicants/store', [\App\Http\Controllers\College\ApplicantController::class, 'store'])->name('college.applicants.store');
            Route::get('/applicants/{applicant}/edit', [\App\Http\Controllers\College\ApplicantController::class, 'edit'])->name('college.applicants.edit');
            Route::get('/applicants/{applicant}/show', [\App\Http\Controllers\College\ApplicantController::class, 'show'])->name('college.applicants.show');
            Route::put('/applicants/{applicant}', [\App\Http\Controllers\College\ApplicantController::class, 'update'])->name('college.applicants.update');
            Route::get('/applicants/{applicant}/password', [\App\Http\Controllers\College\ApplicantController::class, 'password'])->name('college.applicants.password');
            Route::get('/applicants/{user}/activity', [\App\Http\Controllers\College\ApplicantController::class, 'activity'])->name('college.applicants.activity');
            Route::get('/applicants/{snapshot}/snapshot', [\App\Http\Controllers\College\ApplicantController::class, 'snapshot'])->name('college.applicants.snapshot');
            // Заявления
            Route::get('/', [\App\Http\Controllers\College\CollegeController::class, 'index'])->name('college.index');
            Route::get('/statements', [\App\Http\Controllers\College\CollegeController::class, 'statements'])->name('college.statements');
            Route::get('/statements/list', [\App\Http\Controllers\College\CollegeController::class, 'getStatements'])->name('college.statements.list');
            Route::get('/edit', [\App\Http\Controllers\College\CollegeController::class, 'edit'])->name('college.edit');
            Route::put('/{college}', [\App\Http\Controllers\College\CollegeController::class, 'update'])->name('college.update');
            Route::get('/statements/create', [\App\Http\Controllers\College\StatementController::class, 'create'])->name('college.statements.create');
            Route::get('/statements/{statement}/show', [\App\Http\Controllers\College\StatementController::class, 'show'])->name('college.statements.show');

            // Специальности
            Route::get('/specialities', [\App\Http\Controllers\College\SpecialityController::class, 'index'])->name('college.specialities');
            Route::get('/specialities/list', [\App\Http\Controllers\College\SpecialityController::class, 'getSpecialities'])->name('college.specialities.list');
            Route::get('/specialities/create', [\App\Http\Controllers\College\SpecialityController::class, 'create'])->name('college.specialities.create');
            Route::get('/specialities/{speciality}/edit', [\App\Http\Controllers\College\SpecialityController::class, 'edit'])->name('college.specialities.edit');
            Route::post('/specialities/store', [\App\Http\Controllers\College\SpecialityController::class, 'store'])->name('college.specialities.store');
            Route::put('/specialities/{speciality}', [\App\Http\Controllers\College\SpecialityController::class, 'update'])->name('college.specialities.update');
            Route::get('/{speciality}/qualifications/list', [\App\Http\Controllers\College\QualificationController::class, 'getQualifications'])->name('college.qualifications.list');
            Route::get('/{speciality}/testings/list', [\App\Http\Controllers\College\TestingController::class, 'getTestings'])->name('college.testings.list');

            // Результаты испытаний
            Route::get('/results', [\App\Http\Controllers\College\ResultController::class, 'index'])->name('college.results');
            Route::get('/results/list', [\App\Http\Controllers\College\ResultController::class, 'getResults'])->name('college.results.list');
            Route::get('/results/{speciality}/create', [\App\Http\Controllers\College\ResultController::class, 'create'])->name('college.results.create');
            Route::get('/results/{result}/edit', [\App\Http\Controllers\College\ResultController::class, 'edit'])->name('college.results.edit');
            Route::post('/results/store', [\App\Http\Controllers\College\ResultController::class, 'store'])->name('college.results.store');
            Route::put('/results/{result}', [\App\Http\Controllers\College\ResultController::class, 'update'])->name('college.results.update');

            //Статистика
            Route::get('/statistic', [App\Http\Controllers\College\ReportController::class, 'index'])->name('college.statistic.index');
            Route::get('/statistic/list', [App\Http\Controllers\College\ReportController::class, 'getStatistics'])->name('college.statistic.list');
        });
    });

    //Абитуриенты
    Route::prefix('applicant')->group(function () {
        Route::group(['middleware' => 'role:user'], function() {
            Route::get('/', [\App\Http\Controllers\Applicant\ApplicantController::class, 'index'])->name('applicant.index');
            Route::get('/info', [\App\Http\Controllers\Applicant\ApplicantController::class, 'edit'])->name('applicant.edit');
            Route::put('/{applicant}', [\App\Http\Controllers\Applicant\ApplicantController::class, 'update'])->name('applicant.update');
            Route::get('/statement', [StatementController::class, 'index'])->name('applicant.statement.index');
            Route::get('/statement/list', [StatementController::class, 'getStatement'])->name('applicant.statement.list');
            Route::get('/statement/create', [StatementController::class, 'create'])->name('applicant.statement.create');
            Route::post('/statement/store', [StatementController::class, 'store'])->name('applicant.statement.store');
            Route::post('/statement/store', [StatementController::class, 'store'])->name('applicant.statement.store');
            Route::post('/statement/delete', [StatementController::class, 'delete'])->name('applicant.statement.delete');
            Route::post('/statement/message', [StatementController::class, 'message'])->name('applicant.statement.message');

            Route::post('/education-form', [StatementController::class, 'educationForm']);
            Route::post('/speciality', [StatementController::class, 'speciality']);

            Route::get('/diploma', [\App\Http\Controllers\Applicant\DiplomaController::class, 'edit'])->name('diploma.edit');
            Route::put('/diploma/update', [\App\Http\Controllers\Applicant\DiplomaController::class, 'update'])->name('diploma.update');
            Route::get('/diploma/add-subject', [\App\Http\Controllers\Applicant\DiplomaController::class, 'addSubject']);

            Route::get('/documents', [\App\Http\Controllers\Applicant\DocumentController::class, 'edit'])->name('document.edit');

            Route::get('/contacts', [\App\Http\Controllers\Applicant\ContactController::class, 'contacts'])->name('applicant.contacts');
            Route::get('/contacts/{college}/message', [\App\Http\Controllers\Applicant\ContactController::class, 'message'])->name('applicant.contacts.message');
            Route::get('/message', [\App\Http\Controllers\Applicant\ContactController::class, 'message'])->name('applicant.message');
            Route::get('/contacts/list', [\App\Http\Controllers\Applicant\ContactController::class, 'getContacts'])->name('applicant.contacts.list');
            Route::post('/contacts/store', [\App\Http\Controllers\Applicant\ContactController::class, 'store'])->name('applicant.contacts.store');
        });
    });

    Route::get('/users/activity-list', [UserController::class, 'getActivity'])->name('users.activity.list');
    Route::post('/users/change', [UserController::class, 'change'])->name('users.password.change');
    Route::get('changeStatus', [UserController::class, 'changeStatus']);
    Route::get('specialityStatus', [\App\Http\Controllers\College\SpecialityController::class, 'changeStatus']);
    Route::get('qualificationStatus', [\App\Http\Controllers\College\QualificationController::class, 'changeStatus']);
    Route::get('testingStatus', [\App\Http\Controllers\College\TestingController::class, 'changeStatus']);
    Route::get('changeCollege', [CollegeController::class, 'changeStatus']);
    Route::get('deleteCollege', [CollegeController::class, 'deleteCollege']);
    Route::get('changeApplicant', [ApplicantController::class, 'changeApplicant']);
    Route::get('get/{file_name}', [\App\Http\Controllers\Applicant\ApplicantController::class, 'downloadFile'])->name('downloadFile');

    Route::post('/qualification/add', [\App\Http\Controllers\College\QualificationController::class, 'addQualification']);
    Route::post('/qualification/edit', [\App\Http\Controllers\College\QualificationController::class, 'editQualification']);

    Route::post('/testing/add', [\App\Http\Controllers\College\TestingController::class, 'addTesting']);
    Route::post('/testing/edit', [\App\Http\Controllers\College\TestingController::class, 'editTesting']);

    Route::get('/message', [ContactController::class, 'message'])->name('message');
    Route::post('/message/store', [ContactController::class, 'store'])->name('message.store');

    Route::get('/statements/{statement}/accept', [\App\Http\Controllers\College\StatementController::class, 'accept'])->name('college.statements.accept');
    Route::get('/statements/{statement}/refute', [\App\Http\Controllers\College\StatementController::class, 'refute'])->name('college.statements.refute');
    Route::post('/statements/reject', [\App\Http\Controllers\College\StatementController::class, 'reject'])->name('college.statements.reject');
    Route::get('/statements/{statement}/going', [\App\Http\Controllers\College\StatementController::class, 'going'])->name('college.statements.going');
    Route::get('/statements/{statement}/refuse', [\App\Http\Controllers\College\StatementController::class, 'refuse'])->name('college.statements.refuse');


    Route::get('download/{file}', [\App\Http\Controllers\HomeController::class, 'download'])->name('download');
});

Route::post('/documents/store-file', [\App\Http\Controllers\Applicant\DocumentController::class, 'store'])->name('documents.store');
Route::post('/documents/delete-file', [\App\Http\Controllers\Applicant\DocumentController::class, 'destroy'])->name('documents.destroy');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/search', [Select2SearchController::class, 'index']);
Route::get('/ajax-college-search', [Select2SearchController::class, 'collegeSearch']);
Route::get('/ajax-speciality-search', [Select2SearchController::class, 'specialitySearch']);
Route::get('/ajax-address-search', [Select2SearchController::class, 'addressSearch']);
Route::get('/ajax-house-search', [Select2SearchController::class, 'houseSearch']);
Route::get('/jur-address-search', [Select2SearchController::class, 'jurAddressSearch']);
});

