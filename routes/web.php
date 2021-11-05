<?php

use App\Http\Controllers\AuthController;
use App\Http\Livewire\Admin\Mentor;
use App\Http\Livewire\Admin\Schedule;
use App\Http\Livewire\Admin\Transaction;
use App\Http\Livewire\Auth\Register;
use App\Http\Livewire\Chat\Chat;
use App\Http\Livewire\Chat\ChatDetail;
use App\Http\Livewire\Client\ActivePlan;
use App\Http\Livewire\Client\HomeUser;
use App\Http\Livewire\Client\Mentor as ClientMentor;
use App\Http\Livewire\Client\MentorDetail;
use App\Http\Livewire\Client\MentorProfile;
use App\Http\Livewire\Client\ProfileUser;
use App\Http\Livewire\Client\Subscription;
use App\Http\Livewire\CrudGenerator;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Master\Bank;
use App\Http\Livewire\Master\Category;
use App\Http\Livewire\Master\Plan;
use App\Http\Livewire\Master\SubCategory;
use App\Http\Livewire\Settings\Menu;
use App\Http\Livewire\UserManagement\Permission;
use App\Http\Livewire\UserManagement\PermissionRole;
use App\Http\Livewire\UserManagement\Role;
use App\Http\Livewire\UserManagement\User;
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
    return redirect('home-user');
});


Route::post('login', [AuthController::class, 'login'])->name('admin.login');
Route::post('register', [Register::class, 'store'])->name('user.register');
Route::group(['middleware' => ['auth:sanctum', 'verified', 'user.authorization']], function () {
    // Crud Generator Route
    Route::get('/crud-generator', CrudGenerator::class)->name('crud.generator');

    // user management
    Route::get('/permission', Permission::class)->name('permission');
    Route::get('/permission-role/{role_id}', PermissionRole::class)->name('permission.role');
    Route::get('/role', Role::class)->name('role');
    Route::get('/user', User::class)->name('user');
    Route::get('/menu', Menu::class)->name('menu');

    // App Route
    Route::get('/dashboard/{period?}', Dashboard::class)->name('dashboard');

    // Master data
    Route::get('/category', Category::class)->name('category');
    Route::get('/sub-category', SubCategory::class)->name('sub-category');
    Route::get('/plan', Plan::class)->name('plan');
    Route::get('/bank', Bank::class)->name('bank');

    // app
    Route::get('/data-mentor', Mentor::class)->name('data-mentor');

    // subscription
    Route::get('/subscription/{plan_id}', Subscription::class)->name('subscription');

    // transaction
    Route::get('/transaction', Transaction::class)->name('transaction');

    // client
    Route::get('/active-plan', ActivePlan::class)->name('active-plan');
    Route::get('/schedule', Schedule::class)->name('schedule');
    Route::get('/profile', MentorProfile::class)->name('mentor.profile');
    Route::get('/user-profile', ProfileUser::class)->name('user.profile');
});

Route::get('/', HomeUser::class)->name('home-user');
Route::get('/mentor/{search?}', ClientMentor::class)->name('mentor');
Route::get('/mentor/detail/{mentor_id}', MentorDetail::class)->name('mentor.detail');

Route::get('/chat', Chat::class)->name('chat');
Route::get('/chat/detail/{chat_id}', ChatDetail::class)->name('chat.detail');
