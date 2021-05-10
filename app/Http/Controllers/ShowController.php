<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Destination;
use App\Models\Service;
use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;


class ShowController extends Controller
{
    use GeneralTrait;


    // to get all destinations that they are in app
    public function getAllDestination()
    {
        $destination = Destination::select('id','name','image')->get();
        return $this->returnData('Name',$destination,'success get','201');
    }

    public function uploadDestinationImage(Request $request,$id)
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



    // to get destination that belongs to a specific user by using user_id
//    public function getDestination($id)
//    {
//        $destination = Destination::with('user')->select('name')->where('user_id',$id)->get();
//        return $this->returnData('Name',$destination,'success get','201');
//    }



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



    // to get all areas that belong to a specific destination by using destination_id
    public function getArea(Request $request)
    {
        $area = Area::with('destination')->select('image','id')->where('destination_id',$request->input('destination_id'))->get();
        return $this->returnData('Name',$area,'all area in this destination','201');
    }



    // to get all services that belong to a specific area by using area_id
    public function getService(Request $request)
    {
        $service = Service::with('area')->select('name','id','image')->where('area_id',$request->input('area_id'))->get();
        return $this->returnData('Name',$service,'success get','201');
    }

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







}
