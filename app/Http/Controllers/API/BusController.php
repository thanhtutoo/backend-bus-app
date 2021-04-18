<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bus;
use App\Models\BusStop;
use App\Models\BusTiming;
use App\Http\Resources\BusResource;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\BusRequest;
use App\Interfaces\BusInterface;
class BusController extends Controller
{
    protected $busInterface;
    /**
     * Create a new constructor for this controller
     */
    public function __construct(BusInterface $busInterface)
    {
        $this->busInterface = $busInterface;
    }
     /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
        return $this->busInterface->getAllBus();
   }
 
   /**
    * Store a newly created resource in storage.
    *
    */
    public function store(BusRequest $request)
    {
        return $this->busInterface->requestBus($request);
    }
   /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->busInterface->getBusById($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\BusRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BusRequest $request, $id)
    {
        return $this->busInterface->requestBus($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->busInterface->deleteBus($id);
    }
}
