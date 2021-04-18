<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bus;
use App\Models\BusRoute;
use App\Models\BusTiming;
use App\Http\Resources\BusResource;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\BusTimingRequest;
use App\Interfaces\BusTimingInterface;
class BusTimingController extends Controller
{
    protected $busTimingInterface;
    /**
     * Create a new constructor for this controller
     */
    public function __construct(BusTimingInterface $busTimingInterface)
    {
        $this->busTimingInterface = $busTimingInterface;
    }
     /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
        return $this->busTimingInterface->getAllBusTiming();
   }
 
   /**
    * Store a newly created resource in storage.
    *
    */
    public function store(BusTimingRequest $request)
    {
        return $this->busTimingInterface->requestBusTiming($request);
    }
   /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->busTimingInterface->getBusTimingById($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\BusRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BusTimingRequest $request, $id)
    {
        return $this->busTimingInterface->requestBusTiming($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->busTimingInterface->deleteBusTiming($id);
    }
}
