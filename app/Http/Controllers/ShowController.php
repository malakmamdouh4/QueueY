<?php

namespace App\Http\Controllers;

use App\Area;
use App\Destination;
use App\Service;
use App\Traits\GeneralTrait;
use App\User;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    use GeneralTrait;


    // to get all destinations that they are in app
    public function getAllDestination()
    {
        $destination = Destination::select('name')->get();
        return $this->returnData('Name',$destination,'success get','201');
    }



    // to get destination that belongs to a specific user by using user_id
    public function getDestination($id)
    {
        $destination = Destination::with('user')->select('name')->where('user_id',$id)->get();
        return $this->returnData('Name',$destination,'success get','201');
    }



    // to get all areas that belong to a specific destination by using destination_id
    public function getArea($id)
    {
        $area = Area::with('destination')->select('name')->where('destination_id',$id)->get();
        return $this->returnData('Name',$area,'success get','201');
    }



    // to get all services that belong to a specific area by using area_id
    public function getService($id)
    {
        $service = Service::with('Area')->select('name')->where('Area_id',$id)->get();
        return $this->returnData('Name',$service,'success get','201');
    }














    // to get specific user followed by destination information that belongs to this user
//    public function getDestinationById($id)
//    {
//            $destination = User::with('destination')->get();
//            return $this->returnData('Name',$destination,'success get','201');
//    }


}
