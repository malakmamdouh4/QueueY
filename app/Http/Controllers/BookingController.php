<?php

namespace App\Http\Controllers;

use App\Models\DayMeeting;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Lab;
use App\Models\Meeting;
use App\Models\TimeLab;
use App\Models\TimeMeeting;
use App\Models\Affair;
use App\Traits\GeneralTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;




class BookingController extends Controller
{

    use GeneralTrait;


    // to get all appointments ( booked or not ) in lab service
    public function getDate(Request $request)
    {
        $lab = Lab::find(1);
        $yourDate = $lab->date;
        $lab->day = Carbon::parse($yourDate)->format('l');
        $lab->save();
        $timelab = TimeLab::with('lab')->select('time', 'active', 'lab_id')
            ->where('active', $request->query('active', 0))->get();
        return $this->returnData('Appointment', $timelab, 'success', '201');
    }


    // to book specific appointment by using appointment_id
    public function updateStatus($id)
    {
        $date = TimeLab::find($id);
        if ($date->active == 0) {
            $date->active = 1;
            $date->save();
            return $this->returnSuccessMessage('Lab is booked successfully', '201');
        } else {
            return $this->returnError('404', 'This appointment already booked');
        }
    }


    // to get all departments in area ( faculty )
    public function getDepartment()
    {
        $depart = Department::select('name')->get();
        return response()->json($depart);
    }


    // to get all doctors that belong to a specific department by using department_id
    public function getDoctor($id)
    {
        $doctor = Doctor::with('department')->select('name', 'department_id')
            ->where('department_id', $id)->get();
        return $this->returnData('Name', $doctor, 'success get', '201');
    }


    // to retrieve day instead of date
    public function retrieveDay($id)
    {
        $lab = Lab::find($id);
        $yourDate = $lab->day;
        $day = Carbon::parse($yourDate)->format('l');
        return $this->returnData('Day', $day, 'success', '201');
    }


    // to get all available days
    public function getDayMeetings(Request $request)
    {
        $dayMeeting = DayMeeting::where('active', $request->query('active', 0))->get();
        return $this->returnData('Days', $dayMeeting, 'there are available days', '201');
    }


    // to get all times that belongs to a specific day
    public function getTimeMeetings($id, Request $request)
    {
        $dayMeeting = DayMeeting::find($id);
        if ($dayMeeting->active == 0) {
            $times = TimeMeeting::with('day')->select('time')
                ->where('day_meeting_id', $id)->where('active', $request->query('active', 0))->get();
            return $this->returnData('Time', $times, 'There are times belong to this day', '201');
        } else {
            return $this->returnError('404', 'this day is booked');
        }
    }


    // to book meeting
    public function bookMeeting(Request $request)
    {
        $dayMeeting = DayMeeting::find($request->input('Booking_Day'));
        $timeMeeting = TimeMeeting::find($request->input('Slot_Time'));

        $time = $timeMeeting->id;
        $active = TimeMeeting::pluck('active')->toArray();

        if ($active != 0)
        {
            $dayMeeting->active = 1;
            $dayMeeting->save();
            return $this->returnError('404', 'un available time');
        } else
        {
            for ($time = 4; $timeMeeting->active == 0; $time++)
            {
                if ($dayMeeting->active == 0 && $timeMeeting->active == 0)
                {
                    Meeting::create([
                        'name' => $request->input('name'),
                        'idNumber' => $request->input('Id_Number'),
                        'topic' => $request->input('topic'),
                        'day_meeting_id' => $request->input('Booking_Day'),
                        'time_meeting_id' => $request->input('Slot_Time'),
                    //  'user_id' => Auth()->user()->id ,
                    ]);
                    $timeMeeting->active = 1;
                    $timeMeeting->save();
                    return $this->returnSuccessMessage('Booking Meeting done successfully :) ', '201');
                }
            }
        }
    }


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
                'inquiry' => URL::to('/') . '/storage/' . $imageName
            ]);

            return $this->returnSuccessMessage('your image send successfully','201');
        }
        else
        {
             Affair::create([
                'name' => $request->input('name'),
                'idNumber' => $request->input('Id_Number'),
                'email' => $request->input('email'),
                'inquiry' => $request->input('inquiry')
            ]);

            return $this->returnSuccessMessage('your problem send successfully','201');
        }

    }



}





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
