<?php

namespace App\Repositories;

use App\Http\Requests\BusTimingRequest;
use App\Interfaces\BusTimingInterface;
use App\Traits\ResponseAPI;
use App\Models\BusTiming;
use DB;
use Illuminate\Http\Request;

class BusTimingRepository implements BusTimingInterface
{
    // Use ResponseAPI Trait in this repository
    use ResponseAPI;

    public function getAllBusTiming()
    {
        try {
            $bus_timings = BusTiming::all();
            return $this->success("All BusTimings", $bus_timings);
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function getBusTimingById($id)
    {
        try {
            $bus_timing = BusTiming::find($id);
            
            // Check the busTiming
            if(!$bus_timing) return $this->error("No bus_timing with ID $id", 404);

            return $this->success("BusTiming Detail", $bus_timing);
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function requestBusTiming(BusTimingRequest $request, $id = null)
    {
        DB::beginTransaction();
        try {
            // If bus exists when we find it
            // Then update the busTiming
            // Else create the new one.
            $bus_timing = $id ? BusTiming::find($id) : new BusTiming;

            // Check the bustiming
            if($id && !$bus_timing) return $this->error("No bustiming with ID $id", 404);

            $bus_timing->arrival_timing = $request->arrival_timing;
            $bus_timing->bus_stop_id = $request->bus_stop_id;
            $bus_timing->bus_id = $request->bus_id;
            // Save the busTiming
            $bus_timing->save();

            DB::commit();
            return $this->success(
                $id ? "BusTiming updated"
                    : "BusTiming created",
                $bus_timing, $id ? 200 : 201);
        } catch(\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), 422);
        }
    }

    public function deleteBusTiming($id)
    {
        DB::beginTransaction();
        try {
            $bus_timing = BusTiming::find($id);

            // Check the busTiming
            if(!$bus_timing) return $this->error("No busTiming with ID $id", 404);

            // Delete the busTiming
            $bus_timing->delete();

            DB::commit();
            return $this->success("BusTiming deleted", $bus_timing);
        } catch(\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }
}