<?php

namespace App\Http\Controllers;

use App\Models\DayMeeting;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Meeting;
use App\Models\TimeMeeting;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;




class MeetingController extends Controller
{
    use GeneralTrait ;


    // to get all departments in area ( faculty )
    public function getDepartment()
    {
        $department = Department::select('id','name','image')->get();
        return $this->returnData('Departments', $department, 'There are all departments', '201');
    }


    // to upload image for every department by using department_id
    public function uploadDeptImage(Request $request,$id)
    {
        if ($request->hasFile('image')){
            $imageExt = $request->file('image')->getClientOriginalExtension();
            $imageName = time().'.'.$imageExt;
            $request->file('image')->storeAs('/public',$imageName);

            $department = Department::find($id);
            $department->image = URL::to('/') . '/storage/' . $imageName;
            $department->save();

            return $this->returnData('image_url',$department->image,'image saved successfully','201');
        }
        else
        {
            return $this->returnError('404','invalid input');
        }
    }


    // to get all doctors that belong to a specific department by using department_id
    public function getDoctor(Request $request)
    {
        $doctor = Doctor::with('department')->select('id','name', 'image','department_id')
            ->where('department_id', $request->input('department_id'))->get();
        return $this->returnData('Doctor', $doctor, 'There are all doctors belong to this department', '201');
    }


    // to upload image for every doctor bu using doctor_id
    public function uploadDoctorImage(Request $request,$id)
    {
        if ($request->hasFile('image')){
            $imageExt = $request->file('image')->getClientOriginalExtension();
            $imageName = time().'.'.$imageExt;
            $request->file('image')->storeAs('/public',$imageName);

            $doctor = Doctor::find($id);
            $doctor->image = URL::to('/') . '/storage/' . $imageName;
            $doctor->save();

            return $this->returnData('image_url',$doctor->image,'image saved successfully','201');
        }
        else
        {
            return $this->returnError('404','failed to save');
        }
    }


    // to get all available days
    public function getDayMeetings(Request $request)
    {
        $dayMeeting = DayMeeting::where('active', $request->query('active', 0))->get();
        return $this->returnData('Days', $dayMeeting, 'there are available days', '201');
    }


    // to get all times that belongs to a specific day
    public function getTimeMeetings(Request $request)
    {
        $dayMeeting = DayMeeting::find($request->input('day_id'));

        if ($dayMeeting->active == 0)
        {
            $times = TimeMeeting::with('day')->select('id','time')
                ->where('day_meeting_id', $request->input('day_id'))
                ->where('active', $request->query('active', 0))->get();

            return $this->returnData('Times', $times, 'There are times belong to this day', '201');
        }
        else
        {
            return $this->returnError('404', 'this day is booked');
        }
    }


    // to book meeting
    public function bookMeeting(Request $request)
    {
        $dayMeeting = DayMeeting::find($request->input('Booking_Day'));
        $timeMeeting = TimeMeeting::find($request->input('Slot_Time'));

        $labs = DB::table('time_meetings')->where('active', 0)->pluck('active')->count();

        if($timeMeeting->active == 0 && $dayMeeting->active == 0)

        {
            Meeting::create([
                'name' => $request->input('name'),
                'idNumber' => $request->input('Id_Number'),
                'topic' => $request->input('topic'),
                'day_meeting_id' => $request->input('Booking_Day'),
                'time_meeting_id' => $request->input('Slot_Time'),
                'user_id' => auth()->user()->id ,
                'doctor_id'=> $request->input('doctor_id')
            ]);

            $timeMeeting->active = 1;
            $timeMeeting->save();

            if ($labs == 1)
            {
                $dayMeeting->active = 1;
                $dayMeeting->save();

                return $this->returnSuccessMessage('This day is not available now:) ', '201');

            }

            return $this->returnSuccessMessage('Booking Meeting done successfully :) ', '201');
        }


    }

}



