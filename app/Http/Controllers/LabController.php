<?php

namespace App\Http\Controllers;

use App\Models\TimeLab;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class LabController extends Controller
{
    use GeneralTrait;


    // to add am or pm to time in lab service
    public function timePeriod()
    {
//        $lab = TimeLab::select('time')->where('id',1)->get();
        $lab = "1:2";
        $timePeriod =  date('h:i A', strtotime($lab));
        return $timePeriod;
    }


    // to get all appointments ( booked or not ) in lab service
    public function getDate(Request $request) //dashboard
    {
        //   $lab = Lab::all();
//        $labs =DB::table('labs')->pluck('date');
//        foreach ($labs as $lab) {
//            $yourDate = $labs->date;
//            $labs->day = Carbon::parse($yourDate)->format('l');
//            $lab->save();
//        }


        $timelab = TimeLab::with('lab')->select('time', 'active','id', 'lab_id')
            ->where('active', $request->query('active', 0))->get();
        return $this->returnData('Appointment', $timelab, 'success', '201');
    }



    // to book specific appointment in lab service by using id
    public function updateStatus(Request $request)
    {
        $date = TimeLab::find($request->input('timelab_id'));
        if ($date->active == 0) {
            $date->active = 1;
            $date->save();
            return $this->returnSuccessMessage('Lab is booked successfully', '201');
        } else {
            return $this->returnError('404', 'This appointment already booked');
        }
    }
}
