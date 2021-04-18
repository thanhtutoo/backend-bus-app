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
    public function bus_stops(Request $request)
    {
        return $this->busInterface->getNearByBusStop($request);
    //     // $lat = 1.3264635;
    //     // //1.3272247,103.884878
    //     // //1.3518888,103.8341397,
    //     // //1.3518888,103.8341397 bishan
    //     // //1.3264635,103.8865065 blk 77
    //     // $lng = 103.8865065;
    //     // // $bus_stops = BusStop::with('bus_timings')->get();
    //     // $bus_stops = DB::table('bus_stops')->select("bus_stop_id", "bus_stop_name"

    //     // ,DB::raw("6371 * acos(cos(radians(" . $lat . ")) 
    //     // * cos(radians(bus_stops.lat)) 
    //     // * cos(radians(bus_stops.lng) - radians(" . $lng . ")) 
    //     // + sin(radians(" .$lat. ")) 
    //     // * sin(radians(bus_stops.lat))) AS distance"))
    //     // ->orderBy('distance', 'asc')
    //     // ->having('distance', '<', 1)
    //     // ->get();
    //     // return response($bus_stops, 200);
    }
    public function bus_list($bus_stop_id)
    {
        return $this->busInterface->getBusByBusStopId($bus_stop_id);
    }
}
