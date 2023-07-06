<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {

        $users = request()->has(['page', 'limit']) ?
            User::latest()->get()->forPage(request('page'), request('limit')) :
            User::latest()->orderBy('id')->paginate(10);
        
        return UserResource::collection($users);

    }

    /**
     * Author Posts
     * @param      \App\Models\User  $user
     * @return     \App\Resources\UserResource
     */
    public function posts(User $user)
    {
        return new UserResource($user->loadMissing('posts'));
            
    }

    /**
     * Author Courses
     * @param      \App\Models\User  $user
     * @return     \App\Http\Resources\UserResource
     */
    public function courses(User $user)
    {
        return new UserResource($user->loadMissing('courses'));
    }

    /**
     * Users Referral
     * @param      \App\Models\User  $user
     * @return     App\Http\Resources\UserResource
     */
    public function referral(User $user)
    {
        return new UserResource($user->loadMissing('referrals'));
    }

    /**
     * Store a newly created resource in storage.
     * @param \App\Http\Resources\StoreUserReques$requestt
     */
    public function store(StoreUserRequest $request)
    {
        $attributes = $request->validated();
        User::create($attributes);
        return response(true);
    }

    /**
     * Display the specified resource.
     * @param \App\Models\User $user
     * @return \App\Http\Resources\UserResource
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage
     * @param \App\Http\Resource\UpdateUserRequest $request
     * @param \App\Models\User $user
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());
        
        if(request()->has('roles'))
            $user->assignRole(request('roles'));
        
        return response(true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response(true);
    }
}
