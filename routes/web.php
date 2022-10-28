<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

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

Route::get('test', function() {
    Storage::disk('google')->put('testingkalaks.txt', 'Hello World');
    dd('done');
});

Route::get('/', function () {
    return view('welcome');
});

// User Routes
Route::controller(UserController::class)->group(function () {
    Route::get('/logout', 'destroy')->name('logout');
    Route::get('/projects', 'Projects')->name('projects');
    Route::get('/submit', 'SubmitThesis')->name('submit');
    Route::post('/store/thesis', 'StoreThesis')->name('store.thesis');

    Route::get('/about', 'About')->name('about');
    Route::get('/profile', 'Profile')->name('profile');
    Route::get('/edit/profile', 'EditProfile')->name('edit.profile');
    Route::post('/store/profile', 'StoreProfile')->name('store.profile');

    Route::get('/archives', 'ArchivesList')->name('archives');
    Route::get('/view/archives/{id}', 'ViewArchives')->name('view.archives');
    Route::get('/edit/archives/{id}', 'EditArchives')->name('edit.archives');
    Route::post('/update/archives/{id}', 'UpdateArchives')->name('update.archives');

    Route::get('/change/password', 'ChangePassword')->name('change.password');
    Route::post('/update/password', 'UpdatePassword')->name('update.password');

    Route::get('/department/cce', 'DeptCCE')->name('department.cce');
    Route::get('/department/chas', 'DeptCHAS')->name('department.chas');
    Route::get('/department/ceas', 'DeptCEAS')->name('department.ceas');
    Route::get('/department/cbaa', 'DeptCBAA')->name('department.cbaa');
    Route::get('/department/mae', 'DeptMAE')->name('department.mae');
    Route::get('/department/mba', 'DeptMBA')->name('department.mba');
});

Route::get('/dashboard', function () {
    return view('home', ["currentPage" => 'home']);
})->middleware(['auth', 'verified'])->name('home');

require __DIR__.'/auth.php';

// Admin Routes
Route::controller(AdminController::class)->group(function () {
    Route::get('/admin/logout', 'destroy')->name('admin.logout');
    Route::get('/admin/profile', 'Profile')->name('admin.profile');
    Route::get('/admin/edit/profile', 'EditProfile')->name('admin.edit.profile');
    Route::post('/admin/store/profile', 'StoreProfile')->name('admin.store.profile');

    Route::get('/admin/change/password', 'ChangePassword')->name('admin.change.password');
    Route::post('/admin/update/password', 'UpdatePassword')->name('admin.update.password');

    Route::get('/admin/user/list', 'UserList')->name('admin.user.list');
    Route::post('/admin/user/register', 'RegisterUser')->name('admin.user.register');
});

Route::get('/admin/dashboard', function () {
    return view('admin.index');
})->middleware(['auth:admin', 'custom_verify'])->name('admin.dashboard');

require __DIR__.'/adminauth.php';
