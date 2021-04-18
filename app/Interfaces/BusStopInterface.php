<?php

namespace App\Interfaces;

use App\Http\Requests\BusStopRequest;
use Illuminate\Http\Request;
interface BusStopInterface
{
    /**
     * Get all busstop
     * 
     * @method  GET api/busstop
     * @access  public
     */
    public function getAllBusStop();

    /**
     * Get Bus By ID
     * 
     * @param   integer     $id
     * 
     * @method  GET api/busstop/{id}
     * @access  public
     */
    public function getBusStopById($id);

    /**
     * Create | Update Bus
     * 
     * @param   \App\Http\Requests\Request    $request
     * @param   integer                           $id
     * 
     * @method  POST    api/busstop       For Create
     * @method  PUT     api/busstop/{id}  For Update     
     * @access  public
     */
    public function requestBusStop(BusStopRequest $request, $id = null);

    /**
     * Delete Bus
     * 
     * @param   integer     $id
     * 
     * @method  DELETE  api/busstop/{id}
     * @access  public
     */
    public function deleteBusStop($id);
}