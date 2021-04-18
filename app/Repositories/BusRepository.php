<?php

namespace App\Repositories;

use App\Http\Requests\BusRequest;
use App\Interfaces\BusInterface;
use App\Traits\ResponseAPI;
use App\Models\Bus;
use App\Models\BusTiming;
use DB;

class BusRepository implements BusInterface
{
    // Use ResponseAPI Trait in this repository
    use ResponseAPI;

    public function getAllBus()
    {
        try {
            $buses = Bus::all();
            return $this->success("All Buses", $buses);
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function getBusById($id)
    {
        try {
            $bus = Bus::find($id);
            
            // Check the bus
            if(!$bus) return $this->error("No bus with ID $id", 404);

            return $this->success("Bus Detail", $bus);
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function requestBus(BusRequest $request, $id = null)
    {
        DB::beginTransaction();
        try {
            // If bus exists when we find it
            // Then update the bus
            // Else create the new one.
            $bus = $id ? Bus::find($id) : new Bus;

            // Check the bus 
            if($id && !$bus) return $this->error("No bus with ID $id", 404);

            $bus->bus_name = $request->bus_name;
            // Remove a whitespace and make to lowercase
            $bus->bus_number = $request->bus_number;
            // Save the bus
            $bus->save();

            DB::commit();
            return $this->success(
                $id ? "Bus updated"
                    : "Bus created",
                $bus, $id ? 200 : 201);
        } catch(\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), 422);
        }
    }

    public function deleteBus($id)
    {
        DB::beginTransaction();
        try {
            $bus = Bus::find($id);

            // Check the bus
            if(!$bus) return $this->error("No bus with ID $id", 404);

            // Delete the bus
            $bus->delete();

            DB::commit();
            return $this->success("Bus deleted", $bus);
        } catch(\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function bus_stops(BusRequest $request)
    {
        try {
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
            return $this->success("Bus Stops", $bus_stops);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }
    public function bus_list($bus_stop_id)
    {
        try {
            $current_time = time();
            $bus_list = BusTiming::where("bus_stop_id", $bus_stop_id)->where("arrival_timing",">",$current_time)->get();
            return $this->success("Bus lists", $bus_list);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }
}