<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Post;
use App\Models\User;
use App\Models\Course;
use App\Models\HireATeam;
use App\Models\Job;
use App\Models\Referral;
use App\Models\Subscribe;
use App\Models\CourseCategory;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::create([
            'fullname' => 'Admin',
            'email' => 'admin@admin.com',
            'telegram_username' => '@danncrypt',
            'twitter_username' => '@etimdaniel08',
            'facebook_username' => 'danny',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'referral_token' => Str::random(12),
            'remember_token' => Str::random(10),
        ]);
        
        User::factory(20)->create();

        Subscribe::factory(20)->create();

        HireATeam::factory(20)->create();

        Job::factory(6)->create();

        Post::factory(20)->create(['user_id' => 2]);
        Post::factory(5)->create(['user_id' => 11]);
        Post::factory(6)->create(['user_id' => 1]);
        Post::factory(10)->create(['user_id' => 3]);

        Referral::factory(10)->create(['referrer' => 1]);
        Referral::factory(5)->create(['referrer' => 2]); 
        Referral::factory(3)->create(['referrer' => 10]); 

        $admin = Role::create(['name' => 'Admin']);
        $writer = Role::create(['name' => 'Writer']);
        $ambassador = Role::create(['name' => 'Ambassador']);
        $writer = Role::create(['name' => 'Moderator']);
        $student = Role::create(['name' => 'Student']);

        $user = User::find(1);
        $user->assignRole('Admin');

        // Post Permission
        $createPost = Permission::create(['name' => 'create_post']);
        $editPost = Permission::create(['name' => 'edit_post']); 
        $deletePost = Permission::create(['name' => 'delete_post']); 
        $viewAllPosts = Permission::create(['name' => 'view_all_posts']);
        
        // Course Permission
        $createCourse = Permission::create(['name' => 'create_course']);
        $editCourse = Permission::create(['name' => 'edit_course']); 
        $deleteCourse = Permission::create(['name' => 'delete_course']); 
        $viewAllCourses = Permission::create(['name' => 'view_all_courses']);

        // User Permission
        $createUser = Permission::create(['name' => 'create_user']);
        $editUser = Permission::create(['name' => 'edit_user']); 
        $deleteUser = Permission::create(['name' => 'delete_user']); 
        $viewAllUsers = Permission::create(['name' => 'view_all_users']);

        // Assign Permission
        $admin = Role::find(1);
        
        $admin->givePermissionTo($createPost);
        $admin->givePermissionTo($editPost);
        $admin->givePermissionTo($deletePost);
        $admin->givePermissionTo($viewAllPosts);
        
        $admin->givePermissionTo($createCourse);
        $admin->givePermissionTo($editCourse);
        $admin->givePermissionTo($deleteCourse);
        $admin->givePermissionTo($viewAllCourses);
        
        $admin->givePermissionTo($createUser);
        $admin->givePermissionTo($editUser);
        $admin->givePermissionTo($deleteUser);
        $admin->givePermissionTo($viewAllUsers);

        CourseCategory::factory(12)->create();
        
        Course::factory(2)->create(['user_id' => 2]);
        Course::factory(6)->create(['user_id' => 5]);
        Course::factory(7)->create(['user_id' => 3]);

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
