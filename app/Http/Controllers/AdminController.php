<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    use GeneralTrait ;


    // to get old password
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


    // to get destination that belongs to a specific user by using user_id
    public function getDestination($id)
    {
        $destination = Destination::with('user')->select('name')->where('user_id',$id)->get();
        return $this->returnData('Name',$destination,'success get','201');
    }


    // هتتعمل فى الداش بورد
//    public function insertDates()
//    {
//
//        for($current = 1 ; $current <= 7 ; $current++ )
//        {
//            $current = Carbon::now();
//            $trialExpires = $current->addDays(1);
//            return response()->json($trialExpires);
//        }
//
//    }


    // to add am or pm to time in lab service
    public function timePeriod()
    {
//        $lab = TimeLab::select('time')->where('id',1)->get();
        $lab = "1:2";
        $timePeriod =  date('h:i A', strtotime($lab));
        return $timePeriod;
    }



    public function insertDates()
    {
      for( $day = 1 ; $day <= 30 ; $day=+1 )
      {
          return 'yes '.$day;
      }
    }

     public function insertPeriod()
     {
         $currentDateTime = '7:30';
         $newDateTime = date('h:i A', strtotime($currentDateTime));
         return $newDateTime ;
     }



    // to retrieve day instead of date
//    public function retrieveDay($id)
//    {
//        $lab = Lab::find($id);
//        $yourDate = $lab->day;
//        $day = Carbon::parse($yourDate)->format('l');
//        return $this->returnData('Day', $day, 'success', '201');
//    }



//    public function image($fileName){
//        $path = public_path().'/uploads/images/'.$fileName;
//        return Response::download($path);
//      }



//    public function image(request $request ,$filename){
//   $file = $request->file('image');
//      // $file= $request->file('image')->getClientOriginalExtension();
//        $destinationPath = "public";
//    //$filename = $file->extension();
//    Storage::putFileAs($destinationPath, $file, $filename);
//         return['image'=> asset('public/' . $this->image->name)];
//
//    }


}
