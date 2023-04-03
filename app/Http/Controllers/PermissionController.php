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
     */
    public function index()
    {
        return PermissionResource::collection(Permission::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePermissionRequest $request)
    {
        $attributes = $request->validated();
        $permission = Permission::create($attributes);

        return $permission ?
                response()->json(['response' => true]) :
                response()->json(['response' => false]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        // return new PermissionResource($permission);
        return $permission;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        //
    }
}