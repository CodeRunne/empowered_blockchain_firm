<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use App\Http\Resources\RoleResource;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return RoleResource::collection(Role::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     * @param \App\Http\Requests\StoreRoleRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRoleRequest $request)
    {
        $attributes = $request->validated();
        $role = Role::create($attributes);

        return $role ?
                response()->json(['response' => true]) :
                response()->json(['response' => false]);
    }

    /**
     * Display the specified resource.
     * @param \Spatie\Permission\Models\Role
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function show(Role $role)
    {
        $role = $role->loadMissing('permissions');
        return new RoleResource($role);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        //
    }
}