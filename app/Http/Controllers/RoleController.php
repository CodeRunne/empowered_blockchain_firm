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
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $roles = request()->has(['page', 'limit']) ?
                    Role::latest()->get()->forPage(request('page'), request('limit')) :
                    Role::latest()->orderBy('id')->paginate(10);

         return RoleResource::collection($roles);
    }

    /**
     * Store a newly created resource in storage.
     * @param \App\Http\Requests\StoreRoleRequest
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoleRequest $request)
    {
        Role::create($request->validated());

        return response()->json([
            'message' => 'Role successfully created'
        ]);
    }

    /**
     * Display the specified resource.
     * @param \Spatie\Permission\Models\Role
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function show(Role $role)
    {
        return new RoleResource($role->loadMissing('permissions'));
    }

    /**
     * Update the specified resource in storage.
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        
        $role->update($request->validated());

        return response()->json([
            'message' => 'Role successfully updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return response()->json([
            'message' => 'Role successfully deleted'
        ]);
    }
}