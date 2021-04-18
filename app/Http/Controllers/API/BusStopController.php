<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bus;
use App\Models\BusStop;
use App\Models\BusTiming;
use App\Http\Resources\BusResource;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\BusStopRequest;
use App\Interfaces\BusStopInterface;
class BusStopController extends Controller
{
    protected $busStopInterface;
    /**
     * Create a new constructor for this controller
     */
    public function __construct(BusStopInterface $busStopInterface)
    {
        $this->busStopInterface = $busStopInterface;
    }
    /**
    * Display a listing of the busstop nearby.
    *
    * @return \Illuminate\Http\Response
    */
    public function bus_stops(Request $request)
    {
        return $this->busStopInterface->getNearByBusStop($request);
    }
    /**
    * Display the specified resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function bus_list($bus_stop_id)
    {
        return $this->busStopInterface->getBusByBusStopId($bus_stop_id);
    }
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
        return $this->busStopInterface->getAllBusStop();
   }
 
   /**
    * Store a newly created resource in storage.
    *
    */
    public function store(BusStopRequest $request)
    {
        return $this->busStopInterface->requestBusStop($request);
    }
   /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->busStopInterface->getBusStopById($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\BusRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BusStopRequest $request, $id)
    {
        return $this->busStopInterface->requestBusStop($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->busStopInterface->deleteBusStop($id);
    }
}
