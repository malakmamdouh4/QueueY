<?php

namespace App\Http\Controllers;

use App\Lab;
use App\TimeLab;
use App\Traits\GeneralTrait;

use Illuminate\Http\Request;

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

}
