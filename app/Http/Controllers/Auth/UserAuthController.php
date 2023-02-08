<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
 use Validator;

class UserAuthController extends Controller
{
    public function register(Request $request)
    {
        // return $request;
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'dob' => 'required|max:255',
            'country_id' => 'required|max:255',
            'state_id' => 'required|max:255',
            'phone' => 'required|max:255',
            'company_name' => 'required|max:255',
            'interests' => 'required|max:255',
            'industry' => 'required|max:255',
            // 'job_title' => 'required|max:255',
            // 'job_level' => 'required|max:255',
            'experience' => 'required',
            'qualification' => 'required|max:255',
            'linkedin_url' => 'required|max:255',
            // 'password' => 'required|confirmed',
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>false,'error'=>$validator->errors()], 401);
        }
        $input = $request->all();
        // $data['password'] = bcrypt($request->password);
        $user = User::create($input);

        $token = $user->createToken('API Token')->accessToken;
        return response()->json(['status'=>true ,'user' => $user, 'token' => $token],200);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=>false,'error'=>$validator->errors()], 401);
        }
        $data = $request->all();
        if (!auth()->attempt($data)) {
            return response(['status'=>false,'error' => 'Incorrect Details.Please try again']);
        }

        $token = auth()->user()->createToken('API Token')->accessToken;

        return response()->json(['status'=>true ,'user' => auth()->user(), 'token' => $token]);

    }
}
