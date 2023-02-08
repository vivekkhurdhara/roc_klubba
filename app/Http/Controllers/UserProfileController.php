<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Validator;


class UserProfileController extends Controller
{
    public function userProfileStore(Request $request)
    {
        $user_id =  auth()->guard('api')->user()->id;
        $check = User::where('id',$user_id)->value('user_profile_status');
        if($check == 1){
            return response(['status'=>false,'error' => 'Profile already exist']);
        }else{
            $validator = Validator::make($request->all(), [
                'user_short' => 'required',
                'user_about' => 'required',
                'designation' => 'required',
                'gender' => 'required',
                'city_id' => 'required',
                'skills' => 'required',
                'functional_areas' => 'required',
                'professional_obejectives' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['status'=>false,'error'=>$validator->errors()], 401);
            }
            $input = $request->all();
            $input['user_id'] =  auth()->guard('api')->user()->id;
            $update_user = User::where('id',$user_id)->update(['user_profile_status'=>1]);
            $user = UserProfile::create($input);
            return response()->json(['status'=>true ,'user' => $user],200);
        }
    }


    public function userDetail()
    {
        $user_id =  auth()->guard('api')->user()->id;
        $user_detail = User::where('id', $user_id)->with('user_profile')->first();
        if($user_detail){
            return response()->json(['status'=>true ,'user_detail' => $user_detail],200);
        }
        return response(['status'=>false,'error' => 'User Not Found']);
    }

    public function userAboutUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_about' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>false,'error'=>$validator->errors()], 401);
        }
        $user_id =  auth()->guard('api')->user()->id;
        $update_about = UserProfile::where('user_id',$user_id)->update(['user_about' => $request->user_about]);

        return response(['status'=>true,'msg' => 'User about updated']);
    }

    public function updateUserProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|max:255',
            'industry' => 'required',
            'experience' => 'required',
            'city_id' => 'required',
            'phone' => 'required',
            'linkedin_url' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>false,'error'=>$validator->errors()], 401);
        }
        $user_id =  auth()->guard('api')->user()->id;

        $update_about = User::where('id',$user_id)->update([
            'full_name' => $request->full_name,
            'industry' => $request->industry,
            'experience' => $request->experience,
            'city_id' => $request->city_id,
            'phone' => $request->phone,
            'linkedin_url' => $request->linkedin_url,
        ]);

        return response(['status'=>true,'msg' => 'User about updated']);

    }
}
