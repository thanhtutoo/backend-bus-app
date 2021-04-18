<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bus;
use App\Models\BusRoute;
use App\Models\BusTiming;
use App\Http\Resources\BusResource;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\BusRouteRequest;
use App\Interfaces\BusRouteInterface;
class BusRouteController extends Controller
{
    protected $busRouteInterface;
    /**
     * Create a new constructor for this controller
     */
    public function __construct(BusRouteInterface $busRouteInterface)
    {
        $this->busRouteInterface = $busRouteInterface;
    }
     /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
        return $this->busRouteInterface->getAllBusRoute();
   }
 
   /**
    * Store a newly created resource in storage.
    *
    */
    public function store(BusRouteRequest $request)
    {
        return $this->busRouteInterface->requestBusRoute($request);
    }
   /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->busRouteInterface->getBusRouteById($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\BusRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BusRouteRequest $request, $id)
    {
        return $this->busRouteInterface->requestBusRoute($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->busRouteInterface->deleteBusRoute($id);
    }
}
