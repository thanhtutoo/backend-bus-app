<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bus;
use App\Http\Resources\BusResource;
class BusController extends Controller
{
    public function bus_list()
    {
        $buses = Bus::all();
        return response([ 'buses' => BusResource::collection($buses), 'message' => 'Retrieved successfully'], 200);
    }
}
