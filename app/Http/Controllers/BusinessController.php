<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Destination;
use App\Models\Meeting;
use App\Models\Option;
use App\Models\Service;
use App\Models\TimeLab;
use App\Models\TimeMeeting;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;



class BusinessController extends Controller
{
    use GeneralTrait;


    // to get all destinations that they are in app
    public function getAllDestination()
    {
        $destination = Destination::select('id','name','image')->get();
        return $this->returnData('Destination',$destination,'There are all destination','201');
    }


    // to upload images for every destination by using destination_id
    public function uploadDestImage(Request $request,$id)
    {
        if ($request->hasFile('image')){
            $imageExt = $request->file('image')->getClientOriginalExtension();
            $imageName = time().'.'.$imageExt;
            $request->file('image')->storeAs('/public',$imageName);

            $destination = Destination::find($id);
            $destination->image = URL::to('/') . '/storage/' . $imageName;
            $destination->save();

            return $this->returnData('image_url',$destination->image,'image saved successfully','201');
        }
        else
        {
            return $this->returnError('404','failed to save');
        }
    }


    // to get all areas that belong to a specific destination by using destination_id
    public function getArea(Request $request)
    {
        $area = Area::with('destination')->select('image','id')->where('destination_id',$request->input('destination_id'))->get();
        return $this->returnData('Area',$area,'There are all areas in this destination','201');
    }


    // to upload images for every area by using area_id
    public function uploadAreaImage(Request $request,$id)
    {
        if ($request->hasFile('image')){
            $imageExt = $request->file('image')->getClientOriginalExtension();
            $imageName = time().'.'.$imageExt;
            $request->file('image')->storeAs('/public',$imageName);

            $area = Area::find($id);
            $area->image = URL::to('/') . '/storage/' . $imageName;
            $area->save();

            return $this->returnData('image_url',$area->image,'image saved successfully','201');
        }
        else
        {
            return $this->returnError('404','failed to save');
        }
    }


    // to get all services that belong to a specific area by using area_id
    public function getService(Request $request)
    {
        $service = Service::with('area')->select('id','name','image')->where('area_id',$request->input('area_id'))->get();
        return $this->returnData('Service',$service,'There are all services in this area','201');
    }


    // to upload images for every service by using service_id
    public function uploadServicesImage(Request $request,$id)
    {
        if ($request->hasFile('image')){
            $imageExt = $request->file('image')->getClientOriginalExtension();
            $imageName = time().'.'.$imageExt;
            $request->file('image')->storeAs('/public',$imageName);

            $service = Service::find($id);
            $service->image = URL::to('/') . '/storage/' . $imageName;
            $service->save();

            return $this->returnData('image_url',$service->image,'image saved successfully','201');
        }
        else
        {
            return $this->returnError('404','failed to save');
        }
    }


    // to get all options
    public function getOption()
    {
        $options = Option::select('id','name','image')->get();
        return $this->returnData('Option', $options, 'There are all options here', '201');
    }


    // to upload image for every option bu using option_id
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


    // to get all notification/appointment
    public function getNotification(Request $request)
    {
        $timelab = TimeLab::with('lab','service')->select('id','time','lab_id','service_id')
            ->where('active', $request->query('active', 1))->get();

        $timemeeting = TimeMeeting::where('active', $request->query('active', 1));

        if($timemeeting)
        {
            $meeting = Meeting::with('day','time','service')->select('day_meeting_id','time_meeting_id','service_id')->get();
        }

        $data =[$timelab,$meeting];
        return $this->returnData('Booked Dates',$data,'There are all booked appointments','201');
    }


}
