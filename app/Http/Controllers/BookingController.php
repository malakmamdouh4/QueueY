<?php

namespace App\Http\Controllers;

use App\Area;
use App\Department;
use App\Doctor;
use App\Lab;
use App\TimeLab;
use App\Traits\GeneralTrait;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookingController extends Controller
{
    use GeneralTrait ;
//    public function index(Request $request)
//    {
//        $customers = Customer::where('active',$request->query('active',0))->get();
//        return view('custom.index',compact('customers'));
//    }


     public function getDate()
     {
         //$lab = Lab::findOrFail($id);
         $timelab = TimeLab::with('lab')->select('value','lab_id')->get();
         return $this->returnData('Day',$timelab,'success','201');
     }
    public function updateStatus($id)
    {
        $date = TimeLab::find($id);
        $date->active = "1";
        $date->save();
        return ('success');
    }

    public function getDepartment(){
         $depart = Department::select('name')->get();
         return response()->json($depart);
    }
////    public function image($fileName){
////        $path = public_path().'/uploads/images/'.$fileName;
////        return Response::download($path);
////    }
//    public function image(request $request ,$filename){
//   $file = $request->file('image');
//      // $file= $request->file('image')->getClientOriginalExtension();
//        $destinationPath = "public";
//    //$filename = $file->extension();
//    Storage::putFileAs($destinationPath, $file, $filename);
//         return['image'=> asset('public/' . $this->image->name)];
//
//    }
        public function getDoctor($id){
            $doctor = Doctor::with('department')->select('name','department_id')->where('department_id',$id)->get();
            return $this->returnData('Name',$doctor,'success get','201');
        }


}
