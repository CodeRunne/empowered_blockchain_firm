<?php

namespace App\Http\Controllers;

use App\Models\Subscribe;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\SubscribeResource;
use App\Http\Requests\StoreSubscribeRequest;
use App\Http\Requests\UpdateSubscribeRequest;

class SubscribeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {   
        $subscribe = request()->has(['page', 'limit']) ?
                    Subscribe::latest()->get()->forPage(request('page'), request('limit')) :
                    Subscribe::latest()->orderBy('id')->paginate(10);

        return SubscribeResource::collection($subscribe);
    }

    /**
     * Store a newly created resource in storage.
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreSubscribeRequest $request)
    {
        $attributes = $request->validated();
        Subscribe::create($attributes);

        return response()->json([
            'message' => "You've successfully subscribed"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Subscribe $subscribe)
    {
        $subscribe->delete();

        return response()->json([
            'message' => "You've successfully unsubscribed"
        ]);
    }
}
