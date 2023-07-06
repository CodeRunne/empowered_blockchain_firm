<?php

namespace App\Http\Controllers;

use App\Models\HireATeam;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Requests\StoreHireATeamRequest;
use App\Http\Requests\StoreContactRequest;

class HomeController extends Controller
{
    public function hire(StoreHireATeamRequest $request) {

        $attributes = $request->validated();
        
        HireATeam::create($attributes);

        return response(['status' => 'success']);
    }

    public function contact(StoreContactRequest $request) {

        $attributes = $request->validated();

        Contact::create($attributes);

        return response(['status' => 'success']);

    }
}
