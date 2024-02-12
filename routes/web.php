<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MessController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\BazarController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\SettingController;

use App\Http\Middleware\AuthGuard;
use App\Http\Middleware\LoginGuard;

//authentication
Route::get('/', [MessController::class, 'home'])->middleware(LoginGuard::class);
Route::post('/send-otp', [MessController::class, 'send_otp']);
Route::post('/authenticate', [MessController::class, 'authenticate']);
Route::post('/register', [MessController::class, 'register']);
Route::post('/logout', [MessController::class, 'logout'])->middleware(AuthGuard::class);

//dashboard
Route::get('/dashboard', [DashboardController::class, 'dashboard'])->middleware(AuthGuard::class);
Route::post('/get-members-data', [DashboardController::class, 'get_members_data'])->middleware(AuthGuard::class);

//member
Route::get('/member', [MemberController::class, 'member'])->middleware(AuthGuard::class);
Route::post('/save-member', [MemberController::class, 'save_member'])->middleware(AuthGuard::class);
Route::post('/get-members', [MemberController::class, 'get_members'])->middleware(AuthGuard::class);
Route::post('/get-total-members', [MemberController::class, 'get_total_members'])->middleware(AuthGuard::class);
Route::post('/update-member', [MemberController::class, 'update_member'])->middleware(AuthGuard::class);
Route::post('/delete-member', [MemberController::class, 'delete_member'])->middleware(AuthGuard::class);
Route::post('/search-member', [MemberController::class, 'search_member'])->middleware(AuthGuard::class);

//deposit
Route::get('/deposit', [DepositController::class, 'deposit'])->middleware(AuthGuard::class);
Route::post('/save-deposit', [DepositController::class, 'save_deposit'])->middleware(AuthGuard::class);
Route::post('/get-deposits', [DepositController::class, 'get_deposits'])->middleware(AuthGuard::class);
Route::post('/get-total-deposited-amount', [DepositController::class, 'get_total_deposited_amount'])->middleware(AuthGuard::class);
Route::post('/update-deposit', [DepositController::class, 'update_deposit'])->middleware(AuthGuard::class);
Route::post('/delete-deposit', [DepositController::class, 'delete_deposit'])->middleware(AuthGuard::class);
Route::post('/filter-deposit', [DepositController::class, 'filter_deposit'])->middleware(AuthGuard::class);

//bazar
Route::get('/bazar', [BazarController::class, 'bazar'])->middleware(AuthGuard::class);
Route::post('/save-bazar', [BazarController::class, 'save_bazar'])->middleware(AuthGuard::class);
Route::post('/get-bazars', [BazarController::class, 'get_bazars'])->middleware(AuthGuard::class);
Route::post('/get-total-bazar-amount', [BazarController::class, 'get_total_bazar_amount'])->middleware(AuthGuard::class);
Route::post('/update-bazar', [BazarController::class, 'update_bazar'])->middleware(AuthGuard::class);
Route::post('/delete-bazar', [BazarController::class, 'delete_bazar'])->middleware(AuthGuard::class);

//meal
Route::get('/meal', [MealController::class, 'meal'])->middleware(AuthGuard::class);
Route::post('/save-meal', [MealController::class, 'save_meal'])->middleware(AuthGuard::class);
Route::post('/get-meals', [MealController::class, 'get_meals'])->middleware(AuthGuard::class);
Route::post('/get-total-meals', [MealController::class, 'get_total_meals'])->middleware(AuthGuard::class);
Route::post('/update-meal', [MealController::class, 'update_meal'])->middleware(AuthGuard::class);
Route::post('/delete-meal', [MealController::class, 'delete_meal'])->middleware(AuthGuard::class);
Route::post('/filter-meal', [MealController::class, 'filter_meal'])->middleware(AuthGuard::class);

