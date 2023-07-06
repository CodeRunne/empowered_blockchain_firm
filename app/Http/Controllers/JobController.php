<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use App\Http\Resources\JobResource;

class JobController extends Controller
{
    public function index() {

        $jobs = request()->has(['page', 'limit']) ?

            Job::latest()->get()->forPage(request('page'), request('limit')) :
            
            Job::latest()->orderBy('id')->get();

        return JobResource::collection($jobs);

    }

    public function store(StoreJobResource $request) {

        $attributes = $request->validated();

        Job::create($attributes);

        return response(['status' => 'success']);

    } 
}
