<?php

namespace App\Interfaces;

use App\Http\Requests\BusRouteRequest;
use Illuminate\Http\Request;
interface BusRouteInterface
{
    /**
     * Get all busroute
     * 
     * @method  GET api/busroute
     * @access  public
     */
    public function getAllBusRoute();

    /**
     * Get Bus By ID
     * 
     * @param   integer     $id
     * 
     * @method  GET api/busroute/{id}
     * @access  public
     */
    public function getBusRouteById($id);

    /**
     * Create | Update Bus
     * 
     * @param   \App\Http\Requests\Request    $request
     * @param   integer                           $id
     * 
     * @method  POST    api/busroute       For Create
     * @method  PUT     api/busroute/{id}  For Update     
     * @access  public
     */
    public function requestBusRoute(BusRouteRequest $request, $id = null);

    /**
     * Delete Bus
     * 
     * @param   integer     $id
     * 
     * @method  DELETE  api/busroute/{id}
     * @access  public
     */
    public function deleteBusRoute($id);
}