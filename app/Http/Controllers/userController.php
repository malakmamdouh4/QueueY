<?php

namespace App\Http\Controllers;

use App\Models\Affair;
use App\Models\Meeting;
use App\Models\Problem;
use App\Models\Rate;
use App\Models\TimeLab;
use App\Models\TimeMeeting;
use App\Traits\GeneralTrait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Validator;


class userController extends Controller
{
    use GeneralTrait ;


    // to sign up as a user or business
    public function register(Request $request) {

        $user = User::create([
                'fullName' => $request->input('fullName') ,
                'email' => $request->input('email') ,
                'phone' => $request->input('phone') ,
                'password' => bcrypt($request->input('password')),
                'title' => $request->input('title') ,
                'busName' => $request->input('busName') ,
                'role' => $request->input('role') ,
                'busCategory' => $request->input('busCategory') ,
                'busPhone' => $request->input('busPhone') ,
                'busEmail' => $request->input('busEmail') ,
                'busWebsite' => $request->input('busWebsite') ,
                'avatar' => $request->input('avatar') ,
        ]);

        return $this->returnData('user',$user,'User registered successfully','201');
    }


    // to login as a user or register
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->returnError('404','You are unauthenticated');
        }

        if (! $token = auth()->attempt($validator->validated())) {
            return $this->returnError('404','You are unauthenticated');
        }

        return $this->createNewToken($token);

    }


    // to return user token
    protected function createNewToken($token)
    {
        $id =auth()->user()->id;
        return $this->returntoken('user_id',$id,'user_token',$token,'You logged successfully','201');
    }


    // to get into user profile
    public function userProfile()
    {
        $profile = [auth()->user()->avatar,auth()->user()->fullName,auth()->user()->phone,auth()->user()->email];
        return $this->returnData('user',$profile,'Welcome in your account','201');
    }


    // to change user_profile image
    public function upload(Request $request)
    {
        $user = User::find(auth()->user()->id);

        if ($user)
        {
            $imageExt = $request->file('avatar')->getClientOriginalExtension();
            $imageName = time() . '.' . $imageExt;
            $request->file('avatar')->storeAs('/public', $imageName);

            $user->avatar = URL::to('/') . '/storage/' . $imageName ;
            $user->save();

            return $this->returnData('Image',$user->avatar,'image changed successfully','201');
        }
        else
        {
            return $this->returnError('404','error invalid');
        }

    }


    // to change user name
    public function editName(Request $request)
    {
        $user = User::find(auth()->user()->id);
        if($user)
        {
            $user->fullName = $request->input('fullName');
            $user->save();
            return $this->returnSuccessMessage('name is changed successfully','201');
        }
        else
        {
            return $this->returnError('404','invalid id');
        }
    }


    // to change user password
    public function editPassword(Request $request)
    {
        $this->validate($request, [
            'old_password'     => 'required',
            'new_password'     => 'required'
        ]);

        $data = $request->all();

        $user = User::find(auth()->user()->id);

        if(!Hash::check($data['old_password'], $user->password))
        {
            return $this->returnError('404','The specified password does not match the database password');
//            return back()
//                ->with('error','The specified password does not match the database password');
        }
        else
        {
            $user->password = bcrypt($request->input('new_password'));
            $user->save();
            return $this->returnSuccessMessage('password updated successfully','201');
        }
    }


    // to contact with affair
    public function getAffair(request $request)
    {
        if ($request->hasFile('inquiry')){
            $imageExt = $request->file('inquiry')->getClientOriginalExtension();
            $imageName = time().'.'.$imageExt;
            $request->file('inquiry')->storeAs('/public',$imageName);

            Affair::create([
                'name' => $request->input('name'),
                'idNumber' => $request->input('Id_Number'),
                'email' => $request->input('email'),
                'inquiry' => URL::to('/') . '/storage/' . $imageName ,
                'area_id' => $request->input('area_id'),
                'user_id' => auth()->user()->id
            ]);

            return $this->returnSuccessMessage('we will contact you soon about this screen','201');
        }
        else
        {
            Affair::create([
                'name' => $request->input('name'),
                'idNumber' => $request->input('Id_Number'),
                'email' => $request->input('email'),
                'inquiry' => $request->input('inquiry'),
                'area_id' => $request->input('area_id'),
                'user_id' => auth()->user()->id
            ]);

            return $this->returnSuccessMessage('we will contact you soon about this problem','201');
        }

    }


    // to send a problem
    public function sendProblem(Request $request)
    {
        if ($request->hasFile('image'))
        {
            $imageExt = $request->file('image')->getClientOriginalExtension();
            $imageName = time() . '.' . $imageExt;
            $request->file('image')->storeAs('/public', $imageName);

            $problem = Problem::create([
                'comment' => $request->input('comment'),
                'image' => URL::to('/') . '/storage/' . $imageName,
                'user_id' => auth()->user()->id
            ]);

            $problem->save();

            return $this->returnSuccessMessage('we work on solving your problem','201');
        }
        else
        {
            $problem = Problem::create([
                'comment' => $request->input('comment'),
                'image' => $request->input('image'),
                'user_id' => auth()->user()->id
            ]);

            $problem->save();

            return $this->returnSuccessMessage('we work on solving your problem','201');
        }

    }


    // te send rate
    public function sendRate(Request $request)
    {
        Rate::create([
            'value' => $request->input('value'),
            'opinion' => $request->input('opinion') ,
            'user_id' => auth()->user()->id
        ]);

        return $this->returnSuccessMessage('Thank you for opinion','201');
    }


    // to delete appointment/notification in any service
    public function deleteNotification(Request $request)
    {
        $notification = TimeLab::find($request->input('lab_id'));
        $meeting = Meeting::find($request->input('meeting_id'));


        if($notification)
        {
            $notification->active = 0 ;
            $notification->save();
            return $this->returnSuccessMessage('201','This time is active now');
        }

        elseif($meeting)
        {
            $timeMeeting =TimeMeeting::find($request->input('timeMeeting_id'));
            $timeMeeting->active= 0;
            $timeMeeting->save();

            DB::delete('delete from meetings where id = ?',[$request->input('meeting_id')]);

            return $this->returnSuccessMessage('201','This time is active now and meeting is deleted');

        }

    }


    // to logout from profile
    public function logout()
    {
        auth()->logout();

        return $this->returnSuccessMessage('user logout successfully', '201');
    }


    // route that must done by using token
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
        auth()->setDefaultDriver('api');
    }


    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }

}


