<?php

namespace App\Interfaces;

use App\Http\Requests\BusTimingRequest;
use Illuminate\Http\Request;
interface BusTimingInterface
{
    /**
     * Get all busTiming
     * 
     * @method  GET api/bustiming
     * @access  public
     */
    public function getAllBusTiming();

    /**
     * Get Bus By ID
     * 
     * @param   integer     $id
     * 
     * @method  GET api/bustiming/{id}
     * @access  public
     */
    public function getBusTimingById($id);

    /**
     * Create | Update Bus
     * 
     * @param   \App\Http\Requests\Request    $request
     * @param   integer                           $id
     * 
     * @method  POST    api/bustiming       For Create
     * @method  PUT     api/bustiming/{id}  For Update     
     * @access  public
     */
    public function requestBusTiming(BusTimingRequest $request, $id = null);

    /**
     * Delete Bus
     * 
     * @param   integer     $id
     * 
     * @method  DELETE  api/bustiming/{id}
     * @access  public
     */
    public function deleteBusTiming($id);
}