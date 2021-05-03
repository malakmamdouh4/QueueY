<?php

namespace App\Http\Controllers;

use App\Traits\GeneralTrait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Validator;


class userController extends Controller
{
    use GeneralTrait ;


    public function register(Request $request) {

        $user = User::create([
                'fullName' => $request->input('fullName') ,
                'email' => $request->input('email') ,
                'phone' => $request->input('phone') ,
                'password' => bcrypt($request->input('password')),
                'title' => $request->input('title') ,
                'busName' => $request->input('busName') ,
                'busCategory' => $request->input('busCategory') ,
                'busPhone' => $request->input('busPhone') ,
                'busEmail' => $request->input('busEmail') ,
                'busWebsite' => $request->input('busWebsite') ,
        ]);

        return $this->returnData('user',$user,'User successfully registered','201');
    }


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


    protected function createNewToken($token)
    {
        return $this->returnData('token',$token,'User logged successfully','201');
    }


    public function userProfile($id)
    {
        $user = User::find($id);
        if($user)
        {
            return $this->returnData('userProfile',[$user->avatar,$user->fullName,$user->phone ,$user->email],
                'User logged successfully','201');
        }
        else
        {
            return $this->returnError('404','invalid id');
        }
    }

     ////// need to update //////////
    public function upload(Request $request,$id)
    {
        $user = User::find($id);

        if ($user)
        {
            $imageExt = $request->file('avatar')->getClientOriginalExtension();
            $imageName = time() . '.' . $imageExt;
            $request->file('avatar')->storeAs('/public', $imageName);

            $user->avatar = URL::to('/') . '/storage/' . $imageName ;
            $user->save();

            return $this->returnData('Image',$user->avatar,'image saved successfully','201');
        }
        else
        {
            return $this->returnError('404','error inavlid');
        }

    }


    public function editName(Request $request,$id)
    {
        $user = User::find($id);
        if($user)
        {
            $user->fullName = $request->input('fullName');
            $user->save();
            return $this->returnSuccessMessage('name is changed well','201');
        }
        else
        {
            return $this->returnError('404','invalid id');
        }
    }


    public function showPassword($id)
    {
        $user = User::find($id);
        if($user)
        {
            return $this->returnData('oldPassword',$user->password,
                'read passowrd','201');
        }
        else
        {
            return $this->returnError('404','invalid id');
        }
    }


    public function editPassword(Request $request,$id)
    {
        $user = User::find($id);

        if ($user) {

            $user->password = bcrypt($request->input('password'));
            $user->save();

            return $this->returnSuccessMessage('password is changed ', '201');
        }
        else
        {
            return $this->returnError('404', 'invalid id');
        }
    }


    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }


    public function logout()
    {
        auth()->logout();

        return $this->returnSuccessMessage('user logout successfully', '201');
    }


    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

}








//        $validator = Validator::make($request->all(), [
//            'fullName' => 'required',
//            'email' => 'required|email|unique:users',
//            'phone' => 'required',
//            'password' => 'required',
//            'title' => 'nullable' ,
//            'busName' => 'nullable',
//            'busCategory' => 'nullable' ,
//            'busPhone' => 'nullable' ,
//            'busWebsite' => 'nullable' ,
//            'busEmail' => 'nullable' ,
//        ]);
//
//        if($validator->fails()){
//            return $this->returnError('402','You failed to sign up');
//        }
//
//        $user = User::create(array_merge(
//            $validator->validated(),
//            ['password' => bcrypt($request->password)]
//        ));
