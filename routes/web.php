<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LangController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\TaskController;
use App\Http\Controllers\Dashboard\DepartmentController;

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
    return view('auth.login');
});

Auth::routes(['register' => false]);
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('lang');


Route::get('productDetails/{id}', [ProductController::class, 'details'])->name('product.details');

/****************************** START ADMIN ROUTES ******************************/
Route::Group(['prefix' => 'admin', 'middleware' => ['auth','lang']], function () { 

    //roles
    Route::resource('role', RoleController::class);
    Route::post('roleDelete', [RoleController::class, 'delete'])->name('role.delete');


    //user
    Route::get('user', [UserController::class, 'index'])->name('user.index');
    Route::post('user/store', [UserController::class, 'store'])->name('user.store');
    Route::get('user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('user/update', [UserController::class, 'update'])->name('user.update');
    Route::delete('user/destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::get('userChangeStatus/{id}', [UserController::class, 'changeStatus'])->name('user.changeStatus');



    //employee
    Route::get('employee', [UserController::class, 'index'])->name('employee.index');


    //department
    Route::resource('department', DepartmentController::class);
    Route::post('departmentDeleteSelected', [DepartmentController::class, 'deleteSelected'])->name('department.deleteSelected');



    //task
    Route::resource('task', TaskController::class);
    Route::post('taskDeleteSelected', [TaskController::class, 'deleteSelected'])->name('task.deleteSelected');
    Route::get('taskChangeStatus/{id}', [TaskController::class, 'changeStatus'])->name('task.changeStatus');

    



    //lang routes
    Route::prefix('lang')->name('lang.')->group( function () {
        Route::controller(LangController::class)->group( function () {
            Route::get('/ar' ,  'ar')->name('ar');
            Route::get('/en' ,  'en')->name('en');
        });
    });

    //general routes
    Route::get('show_file/{folder_name}/{photo_name}', [GeneralController::class, 'show_file'])->name('show_file');
    Route::get('download_file/{folder_name}/{photo_name}', [GeneralController::class, 'download_file'])->name('download_file');
    Route::get('allNotifications', [GeneralController::class, 'allNotifications'])->name('allNotifications');
    Route::get('markAllAsRead', [GeneralController::class, 'markAllAsRead'])->name('markAllAsRead');
});
/****************************** END ADMIN ROUTES ******************************/