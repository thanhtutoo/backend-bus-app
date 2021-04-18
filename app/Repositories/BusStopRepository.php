<?php

namespace App\Repositories;

use App\Http\Requests\BusStopRequest;
use App\Interfaces\BusStopInterface;
use App\Traits\ResponseAPI;
use App\Models\BusStop;
use App\Models\BusTiming;
use DB;
use Illuminate\Http\Request;

class BusStopRepository implements BusStopInterface
{
    public function getNearByBusStop(Request $request)
    {
        try {
            $lat = 1.3264635;
            $lng = 103.8865065;
 
            $bus_stops = DB::table('bus_stops')->select("bus_stop_id", "bus_stop_name"
            ,DB::raw("6371 * acos(cos(radians(" . $lat . ")) 
            * cos(radians(bus_stops.lat)) 
            * cos(radians(bus_stops.lng) - radians(" . $lng . ")) 
            + sin(radians(" .$lat. ")) 
            * sin(radians(bus_stops.lat))) AS distance"))
            ->orderBy('distance', 'asc')
            ->having('distance', '<', 1)
            ->get();
            return $this->success("Bus Stops", $bus_stops);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function getBusByBusStopId($bus_stop_id)
    {
        try {
            $current_time = time();
            $bus_list = BusTiming::with("bus_stop")->where("bus_stop_id", $bus_stop_id)->where("arrival_timing",">",$current_time)->get();
            // dd($bus_list);
            return $this->success("Bus lists", $bus_list);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 422);
        }
    }
    // Use ResponseAPI Trait in this repository
    use ResponseAPI;

    public function getAllBusStop()
    {
        try {
            $bus_stops = BusStop::all();
            return $this->success("All BusStops", $bus_stops);
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function getBusStopById($id)
    {
        try {
            $bus_stop = BusStop::find($id);
            
            // Check the busstop
            if(!$bus_stop) return $this->error("No bus_stop with ID $id", 404);

            return $this->success("BusStop Detail", $bus_stop);
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function requestBusStop(BusStopRequest $request, $id = null)
    {
        DB::beginTransaction();
        try {
            // If bus exists when we find it
            // Then update the busstop
            // Else create the new one.
            $bus_stop = $id ? BusStop::find($id) : new BusStop;

            // Check the busstop
            if($id && !$bus_stop) return $this->error("No busStop with ID $id", 404);

            $bus_stop->bus_stop_name = $request->bus_stop_name;
            // Remove a whitespace and make to lowercase
            $bus_stop->lat = $request->lat;
            $bus_stop->lng = $request->lng;
            $bus_stop->postal_code = $request->postal_code;
            // Save the busstop
            $bus_stop->save();

            DB::commit();
            return $this->success(
                $id ? "BusStop updated"
                    : "BusStop created",
                $bus_stop, $id ? 200 : 201);
        } catch(\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), 422);
        }
    }

    public function deleteBusStop($id)
    {
        DB::beginTransaction();
        try {
            $bus_stop = BusStop::find($id);

            // Check the busstop
            if(!$bus_stop) return $this->error("No busStop with ID $id", 404);

            // Delete the busstop
            $bus_stop->delete();

            DB::commit();
            return $this->success("BusStop deleted", $bus_stop);
        } catch(\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }
}