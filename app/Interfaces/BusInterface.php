<?php

namespace App\Interfaces;

use App\Http\Requests\BusRequest;
use Illuminate\Http\Request;
interface BusInterface
{
    /**
     * Get all bus
     * 
     * @method  GET api/bus
     * @access  public
     */
    public function getAllBus();

    /**
     * Get Bus By ID
     * 
     * @param   integer     $id
     * 
     * @method  GET api/bus/{id}
     * @access  public
     */
    public function getBusById($id);

    /**
     * Create | Update Bus
     * 
     * @param   \App\Http\Requests\Request    $request
     * @param   integer                           $id
     * 
     * @method  POST    api/bus       For Create
     * @method  PUT     api/bus/{id}  For Update     
     * @access  public
     */
    public function requestBus(BusRequest $request, $id = null);

    /**
     * Delete Bus
     * 
     * @param   integer     $id
     * 
     * @method  DELETE  api/bus/{id}
     * @access  public
     */
    public function deleteBus($id);
}