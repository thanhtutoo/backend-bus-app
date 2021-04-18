<?php

namespace App\Interfaces;

use App\Http\Requests\BusRequest;
use Illuminate\Http\Request;
interface BusInterface
{
    /**
     * Get all buse
     * 
     * @method  GET api/buse
     * @access  public
     */
    public function getAllBus();

    /**
     * Get Bus By ID
     * 
     * @param   integer     $id
     * 
     * @method  GET api/buse/{id}
     * @access  public
     */
    public function getBusById($id);

    /**
     * Create | Update Bus
     * 
     * @param   \App\Http\Requests\Request    $request
     * @param   integer                           $id
     * 
     * @method  POST    api/buse       For Create
     * @method  PUT     api/buse/{id}  For Update     
     * @access  public
     */
    public function requestBus(BusRequest $request, $id = null);

    /**
     * Delete Bus
     * 
     * @param   integer     $id
     * 
     * @method  DELETE  api/buse/{id}
     * @access  public
     */
    public function deleteBus($id);
    public function getNearByBusStop(Request $request);
    public function getBusByBusStopId($bus_stop_id);
}