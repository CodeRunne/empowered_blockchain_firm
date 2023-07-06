<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Notifications\ResetPassword;
use Spatie\Permission\Models\{Role, Permission};
use App\Models\{Post, User, Subscribe, Course, CourseCategory};
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Policies\{PostPolicy, SubscribePolicy, RolePolicy, PermissionPolicy, CoursePolicy, CourseCategoryPolicy};

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        'App\Models\Subscribe' => 'App\Policies\SubscribePolicy',
        'App\Models\Post' => 'App\Policies\PostPolicy',
        'Spatie\Permission\Models\Role' => 'App\Policies\RolePolicy',
        'Spatie\Permission\Models\Permission' => 'App\Policies\PermissionPolicy',
        'App\Models\CourseCategory' => 'App\Policies\CourseCategoryPolicy',
        'App\Models\Course' => 'App\Policies\CoursePolicy'
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });

        Gate::before(function(User $user) {
            if($user->hasRole('admin')) {
                return true;
            }
        });
    }
}