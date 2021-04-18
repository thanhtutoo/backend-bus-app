<?php

namespace App\Interfaces;

use App\Http\Requests\BusRequest;

interface BusInterface
{
    /**
     * Get all buses
     * 
     * @method  GET api/buses
     * @access  public
     */
    public function getAllBuss();

    /**
     * Get Bus By ID
     * 
     * @param   integer     $id
     * 
     * @method  GET api/buses/{id}
     * @access  public
     */
    public function getBusById($id);

    /**
     * Create | Update Bus
     * 
     * @param   \App\Http\Requests\BusRequest    $request
     * @param   integer                           $id
     * 
     * @method  POST    api/buses       For Create
     * @method  PUT     api/buses/{id}  For Update     
     * @access  public
     */
    public function requestBus(BusRequest $request, $id = null);

    /**
     * Delete Bus
     * 
     * @param   integer     $id
     * 
     * @method  DELETE  api/buses/{id}
     * @access  public
     */
    public function deleteBus($id);
}