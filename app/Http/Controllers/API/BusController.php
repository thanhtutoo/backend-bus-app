<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bus;
use App\Models\BusStop;
use App\Models\BusTiming;
use App\Http\Resources\BusResource;
use Illuminate\Support\Facades\DB;
class BusController extends Controller
{
    public function bus_stops(Request $request)
    {
        $lat = 1.3264635;
        //1.3272247,103.884878
        //1.3518888,103.8341397,
        //1.3518888,103.8341397 bishan
        //1.3264635,103.8865065 blk 77
        $lng = 103.8865065;
        // $bus_stops = BusStop::with('bus_timings')->get();
        $bus_stops = DB::table('bus_stops')->select("bus_stop_id", "bus_stop_name"

        ,DB::raw("6371 * acos(cos(radians(" . $lat . ")) 
        * cos(radians(bus_stops.lat)) 
        * cos(radians(bus_stops.lng) - radians(" . $lng . ")) 
        + sin(radians(" .$lat. ")) 
        * sin(radians(bus_stops.lat))) AS distance"))
        ->orderBy('distance', 'asc')
        ->having('distance', '<', 1)
        ->get();
        return response($bus_stops, 200);
    }
    public function bus_list(Request $request, $bus_stop_id)
    {
        $current_time = time();
        $bus_list = BusTiming::where("bus_stop_id", $bus_stop_id)->where("arrival_timing",">",$current_time)->get();
        return response($bus_list, 200);
    }
}
