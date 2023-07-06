<?php

use App\Models\Job;
use App\Models\Role;
use App\Models\User;
use App\Models\Post;
use App\Models\Course;
use App\Models\Referral;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\ReferralResource;
use App\Http\Controllers\JobController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\SubscribeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\CourseCategoryController;

// Auth::loginUsingId(2);

// ---> User Api Route
Route::controller(UserController::class)->group(function() {
    Route::get('/users', 'index')->can('viewAny', User::class);
    Route::get('/users/{user}', 'show');
    Route::get('/users/{user}/posts', 'posts');
    Route::get('/users/{user}/courses', 'courses');
    Route::get('/users/{user}/referrals', 'referral');

    Route::middleware(['auth:sanctum', 'verified'])->group(function() {
        Route::post('/users', 'store')->can('create', User::class);
        Route::put('/users/{user}', 'update')->can('update', User::class);
        Route::delete('/users/{user}', 'delete')->can('delete', User::class);
    });
});

// All Post Data Count
Route::get('/posts/count', function() {
    return response()->json([
        'posts_count' => Post::all()->count(),
        'published_count' => Post::published()->count(),
        'unpublished_count' => Post::unpublished()->count()
    ]);
});

// All Course Data Count
Route::get('/courses/count', function() {
    return response()->json([
        'courses_count' => Course::all()->count()
    ]);
});

// All Users Data Count
Route::get('/users/count', function() {
    return response()->json([
        'users_count' => User::all()->count()
    ]);
});

// All Roles Data Count
Route::get('/roles/count', function() {
    return response()->json([
        'roles_count' => \Spatie\Permission\Models\Role::all()->count()
    ]);
});

// All Permissions Data Count
Route::get('/permissions/count', function() {
    return response()->json([
        'permissions_count' => \Spatie\Permission\Models\Permission::all()->count()
    ]);
});

// ---> Post Api Route
Route::controller(PostController::class)->group(function() {
    Route::get('/posts', 'index')->name('posts.index');
    Route::get('/posts/{post:slug}', 'show')->name('posts.show');

    Route::middleware(['auth:sanctum', 'verified'])->group(function() {
        Route::post('/posts', 'store')->can("create", Post::class);
        Route::put('/posts/{post}', 'update')->can("update", Post::class);
        Route::delete('/posts/{post}', 'delete')->can("delete", Post::class);

        Route::post("/posts/tmp-upload", 'tmpUpload');
        Route::delete("/posts/tmp-delete", 'tmpDelete');
    });
});


// ---> Courses Api Route
Route::controller(CourseController::class)->group(function() {
    Route::get('/courses', 'index');
    Route::get('/courses/{course:slug}', 'show')->name('courses.show');

    Route::middleware(['auth:sanctum', 'verified'])->group(function() {
        Route::post('/courses', 'store')->can("create", Course::class);
        Route::put('/courses/{course}', 'update')->can("update", Course::class);
        Route::delete('/courses/{course}', 'delete')->can("delete", Course::class);

        Route::post("/courses/tmp-upload", 'tmpUpload');
        Route::delete("/courses/tmp-delete", 'tmpDelete');
    });
});


// ---> Courses Category Api Route
Route::controller(CourseCategoryController::class)->group(function() {
    Route::get('/courses/category', 'index');
    Route::get('/courses/category/{category:slug}', 'show')->name('course_categories.show');

    Route::middleware(['auth:sanctum', 'verified'])->group(function() {
        Route::post('/courses/category', 'store')->can("create", CourseCategory::class);
        Route::put('/courses/category/{category}', 'update')->can("update", CourseCategory::class);
        Route::delete('/courses/category/{category}', 'delete')->can("delete", CourseCategory::class);
    });
});


// ---> permissions Api Route
Route::controller(RoleController::class)->group(function() {
    Route::get('/roles', 'index')->can('viewAny', Role::class);
    Route::get('/roles/{role}', 'show')->can("view", Role::class);

    Route::middleware(['auth:sanctum', 'verified'])->group(function() {
        Route::post('/roles', 'store')->can("create", Role::class);
        Route::put('/roles/{role}', 'update')->can("update", Role::class);
        Route::delete('/roles/{role}', 'delete')->can("delete", Role::class);
    });
});


// ---> Permissions Api Route
Route::controller(PermissionController::class)->group(function() {
    Route::get('/permissions', 'index')->can('viewAny', Permission::class);
    Route::get('/permissions/{permission}', 'show')->can('view', Permission::class);

    Route::middleware(['auth:sanctum', 'verified'])->group(function() {
        Route::post('/permissions', 'store')->can('create', Permission::class);
        Route::put('/permissions/{permission}', 'update')->can('update', Permission::class);
        Route::delete('/permissions/{permission}', 'delete')->can('delete', Permission::class);
    });
});


// ---> Subscribes Api Route
Route::controller(SubscribeController::class)->group(function() {
    Route::get("/subscribes", 'index')->can('viewAny', Subscribe::class);

    Route::middleware(['auth:sanctum', 'verified'])->group(function() {
        Route::post('/subscribes', 'store');
        Route::delete('/subscribes/{permission}', 'delete');
    });
});
    

// ---> Hire A Talent Api Route
Route::controller(HomeController::class)->group(function() {
    Route::post('/hire-a-talent', 'hire');
    Route::post("/contact", 'contact');
});


// ---> Referral Api Route
Route::get("/referrals", function() {
    return ReferralResource::collection(Referral::paginate(6));
});


// Jobs Api Route
Route::controller(JobController::class)->group(function() {
    Route::get('/jobs', 'index');
    Route::post('/jobs', 'store')->middleware(['auth:sanctum', 'can:create,'.Job::class]);
});


Route::middleware(['auth:sanctum'])->get('/dashboard', function (\Request $request) {
    if(request()->user()->hasRole('Student')) {
        $user = request()->user();

        return response()->json([
            'id' => $user->id,
            'fullname' => $user->fullname,
            'email' => $user->email,
            'roles' => strtolower(request()->user()->roles()->pluck('name')[0]),
            'socials' => [
                'telegram' => $user->telegram_username,
                'twitter' => $user->twitter_username,
                'facebook' => $user->facebook_username
            ],
        ]);

    }

    return new \App\Http\Resources\UserResource(request()->user()->loadMissing('permissions'));
});

require __DIR__.'/auth.php';