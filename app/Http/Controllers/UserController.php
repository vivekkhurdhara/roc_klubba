<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\Designation;
use App\Models\FunctionalArea;
use App\Models\Industry;
use App\Models\Intrest;
use App\Models\ProfessionalObjective;
use App\Models\Skill;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;


class UserController extends Controller
{
    public function checkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
        ]);
        if ($validator->fails()) {
            return response(['status'=>false,'error' => 'Email is required']);
        }
        $check = User::where('email',$request->email)->exists();
        if($check > 0){
            return response(['status'=>false,'error' => 'The email has already been taken.']);
        }
        else{
            return response(['status'=>true,'message' => 'Available']);
        }
        return $check;
    }

    public function countries()
    {
        $countries = Country::pluck('name','id');
        return response()->json(['status'=>true ,'data' => $countries]);
    }

    public function states(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>false,'error'=>$validator->errors()], 401);
        }
        $country_id = $request->country_id;
        $states = State::where('country_id',$country_id)->pluck('name','id');
        return response()->json(['status'=>true ,'data' => $states]);
    }

    public function cities(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_id' => 'required',
            'state_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>false,'error'=>$validator->errors()], 401);
        }
        $country_id = $request->country_id;
        $state_id = $request->state_id;
        $states = City::where('country_id',$country_id)->where('state_id',$state_id)->pluck('name','id');
        return response()->json(['status'=>true ,'data' => $states]);
    }

    public function intrests()
    {
        $intrests = Intrest::pluck('name','id');
        return response()->json(['status'=>true ,'data' => $intrests]);
    }

    public function designations()
    {
        $designations = Designation::pluck('name','id');
        return response()->json(['status'=>true ,'data' => $designations]);
    }

    public function professional_objectives()
    {
        $professional_objectives = ProfessionalObjective::pluck('name','id');
        return response()->json(['status'=>true ,'data' => $professional_objectives]);
    }

    public function industries()
    {
        $industries = Industry::pluck('name','id');
        return response()->json(['status'=>true ,'data' => $industries]);
    }

    public function functional_areas()
    {
        $functional_areas = FunctionalArea::pluck('name','id');
        return response()->json(['status'=>true ,'data' => $functional_areas]);
    }

    public function skills()
    {
        $skills = Skill::pluck('name','id');
        return response()->json(['status'=>true ,'data' => $skills]);
    }
}
