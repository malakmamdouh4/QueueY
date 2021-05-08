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
                'role' => $request->input('role') ,
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

//         $user = auth()->user() ;
//         $token = $user->createToken('token');
//         return $token->plainTextToken;
    }


    protected function createNewToken($token)
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }


    public function userProfile()
    {
        $profile = [auth()->user()->avatar,auth()->user()->fullName,auth()->user()->phone];
        return $this->returnData('user',$profile,'Welcome in your account','201');
    }

     // to upload image for user profile //
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

            return $this->returnData('Image',$user->avatar,'image saved successfully','201');
        }
        else
        {
            return $this->returnError('404','error invalid');
        }

    }


    public function editName(Request $request)
    {
        $user = User::find(auth()->user()->id);
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


    public function showPassword()
    {
        $user = User::find(auth()->user()->id);
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


    public function editPassword(Request $request)
    {
        $this->validate($request, [
            'old_password'     => 'required',
            'new_password'     => 'required'
        ]);
        $data = $request->all();

        $user = User::find(auth()->user()->id);
        if(!Hash::check($data['old_password'], $user->password)){
            return back()
                ->with('error','The specified password does not match the database password');
        }
        else
        {
            $user->password = bcrypt($request->input('new_password'));
            $user->save();
            return $this->returnSuccessMessage('password updated successfully','201');
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
