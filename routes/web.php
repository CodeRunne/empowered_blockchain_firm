<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\ReferralResource;

Auth::loginUsingId(2);
Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

// ------------------- POST API ROUTE --------------------
Route::controller(App\Http\Controllers\PostController::class)->group(function() {
        Route::get('/posts', 'index');
        Route::get('/posts/{post:slug}', 'show');
});

Route::resource("/posts", App\Http\Controllers\PostController::class)
    ->except(['index', 'show'])
    ->middleware(['auth:sanctum', 'verified']);
    
// ------------------- COURSE API ROUTE --------------------
Route::controller(App\Http\Controllers\PostController::class)->group(function() {
    Route::get('/courses', 'index');
    Route::get('/courses/{courses:slug}', 'show');
});

Route::resource("/courses", App\Http\Controllers\CourseController::class)
    ->except(['index', 'show'])
    ->middleware(['auth:sanctum', 'verified']);

// ------------------- ROLES API ROUTE --------------------
Route::controller(App\Http\Controllers\RoleController::class)->group(function() {
    Route::get('/roles', 'index');
    Route::get('/roles/{role:slug}', 'show');
});

Route::resource("/roles", App\Http\Controllers\RoleController::class)
    ->except(['index', 'show'])
    ->middleware(['auth:sanctum', 'verified']);   

// ------------------- PERMISSION API ROUTE --------------------
Route::controller(App\Http\Controllers\PermissionController::class)->group(function() {
    Route::get('/permissions', 'index');
    Route::get('/permissions/{permissions:slug}', 'show');
});

Route::resource("/permissions", App\Http\Controllers\PermissionController::class)
    ->except(['index', 'show'])
    ->middleware(['auth:sanctum', 'verified']);
    
// ------------------- SUBSCRIBE API ROUTE --------------------

Route::get("/subscribes", [App\Http\Controllers\SubscribeController::class, 'index']);

Route::resource("/subscribes", App\Http\Controllers\SubscribeController::class)
    ->only(['create', 'delete'])
    ->middleware(['auth:sanctum', 'verified']); 

    
// ------------------- REFERRAL API ROUTE --------------------

Route::get("/referrals", function() {
    return ReferralResource::collection(App\Models\Referral::paginate(6));
});

// ------------------- DASHBOARD API ROUTE --------------------
Route::controller(App\Http\Controllers\DashboardController::class)->group(function() {
   Route::get("/dashboard", "index");
});

require __DIR__.'/auth.php';