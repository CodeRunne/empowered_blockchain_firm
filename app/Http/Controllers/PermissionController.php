<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;
use App\Http\Resources\PermissionResource;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;

class PermissionController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {

        $permissions = request()->has(['page', 'limit']) ?
                    Permission::latest()->get()->forPage(request('page'), request('limit')) :
                    Permission::latest()->orderBy('id')->paginate(10);

        return PermissionResource::collection($permissions);

    }

    /**
     * Store a newly created resource in storage.
     * @param \App\Http\Requests\StorePermissionRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StorePermissionRequest $request)
    {
        if(request()->user()->can('create', Permission::class)) {
            $attributes = $request->validated();
            $permission = Permission::create($attributes);

            return response()->json([
                'message' => 'Role successfully created'
            ]);
        }
    }

    /**
     * Display the specified resource.
     * @param \App\Models\Permission $permission
     * @return \App\Http\Resources\PermissionResource
     */
    public function show(Permission $permission)
    {
        return new PermissionResource($permission);
    }

    /**
     * Update the specified resource in storage.
     * @param \App\Http\Requests\StorePermissionRequest $request
     * @param \App\Models\Permission $permission
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        $attributes = $request->validated();
        $permission->update($attributes);

        return response()->json([
            'message' => 'Permission successfully updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @param \App\Models\Permission $permission
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Permission $permission)
    {

        $permission->delete();
        
        return response()->json([
            'message' => 'Permission successfully deleted'
        ]);
    }
}