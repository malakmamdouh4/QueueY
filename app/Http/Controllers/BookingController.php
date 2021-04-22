<?php

namespace App\Http\Controllers;

use App\Lab;
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
         $date = Lab::select()->get();
         return $this->returnData('Name',$date,'success','201');
     }
}
