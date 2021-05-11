<?php

namespace App\Http\Controllers;

use App\Models\DayMeeting;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Lab;
use App\Models\Meeting;
use App\Models\Option;
use App\Models\Problem;
use App\Models\Rate;
use App\Models\TimeLab;
use App\Models\TimeMeeting;
use App\Models\Affair;
use App\Traits\GeneralTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;




class BookingController extends Controller
{

    use GeneralTrait;
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


    // to book specific appointment by using appointment_id
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


    // to get all departments in area ( faculty )
    public function getDepartment()
    {
        $depart = Department::select('name','image','id')->get();
        return response()->json($depart);
    }
    public function uploadDepartmentImage(Request $request,$id)
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
            return $this->returnError('404','failed to save');
        }
    }


    // to get all doctors that belong to a specific department by using department_id
    public function getDoctor(Request $request)
    {
        $doctor = Doctor::with('department')->select('name', 'image','id','department_id')
            ->where('department_id', $request->input('department_id'))->get();
        return $this->returnData('Name', $doctor, 'success get', '201');
    }
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


    // to retrieve day instead of date
//    public function retrieveDay($id)
//    {
//        $lab = Lab::find($id);
//        $yourDate = $lab->day;
//        $day = Carbon::parse($yourDate)->format('l');
//        return $this->returnData('Day', $day, 'success', '201');
//    }

    // to get all available days
    public function getDayMeetings(Request $request)
    {
        $dayMeeting = DayMeeting::where('active', $request->query('active', 0))->get();
        return $this->returnData('Days', $dayMeeting, 'there are available days', '201');
    }


    // to get all times that belongs to a specific day
    public function getTimeMeetings(Request $request)
    {
        $dayMeeting = DayMeeting::find($request->input('dayId'));
        if ($dayMeeting->active == 0) {
            $times = TimeMeeting::with('day')->select('time','id')
                ->where('day_meeting_id', $request->input('dayId'))->where('active', $request->query('active', 0))->get();
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

        if ($active != 0) {
            $dayMeeting->active = 1;
            $dayMeeting->save();
            return $this->returnError('404', 'un available time');
        } else {
            for ($time = 4; $timeMeeting->active == 0; $time++) {
                if ($dayMeeting->active == 0 && $timeMeeting->active == 0) {
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

    public function uploadImageOption(Request $request,$id)
    {
        $option = Option::find($id);
        if ($request->hasFile('image'))
        {
            $imageExt = $request->file('image')->getClientOriginalExtension();
            $imageName = time() . '.' . $imageExt;
            $request->file('image')->storeAs('/public', $imageName);
            $option->image = URL::to('/') . '/storage/' . $imageName;
            $option->save();
            return $this->returnData('image_url',$option->image,'image saved successfully','201');
        }
    }


  public function getOption()
  {
      $options = Option::select('name','image','id')->get();
      return $this->returnData('Option', $options, 'There are all options here', '201');
  }

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
          ]);

          $problem->save();

          return $this->returnSuccessMessage('image saved successfully','201');
      }

  }


  public function sendRate(Request $request)
  {
       Rate::create([
           'value' => $request->input('value'),
           'opinion' => $request->input('opinion')
       ]);

      return $this->returnSuccessMessage('Rate send successfully','201');
  }


  public function getNotification(Request $request)
  {
      $timelab = TimeLab::with('lab','service')->select('time','lab_id','service_id')
          ->where('active', $request->query('active', 1))->get();
//      return $this->returnData('Appointment', $timelab, 'success', '201');

      $timemeeting = TimeMeeting::where('active', $request->query('active', 1));
      if($timemeeting)
      {
          $meeting = Meeting::with('day','time')->select('day_meeting_id','time_meeting_id')->get();
      }
      $data =[$timelab,$meeting];
      return response()->json($data);
  }

  public function deleteNotification(Request $request)
  {
      $meeting = Meeting::find($request->input('meetingId'));
      $notification = TimeLab::find($request->input('labId'));
      if($notification)
      {
          $notification->active = 0 ;
          $notification->save();
          return $this->returnSuccessMessage('201','This time is active now');
      }
      elseif($meeting){
          $timeMeeting =TimeMeeting::find($request->input('timeMeetingId'));
          $timeMeeting->active= 0;
          $timeMeeting->save();
          DB::delete('delete from meetings where id = ?',[$request->input('meetingId')]);
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
