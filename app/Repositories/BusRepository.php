<?php

namespace App\Repositories;

use App\Http\Requests\BusRequest;
use App\Interfaces\BusInterface;
use App\Traits\ResponseAPI;
use App\Models\Bus;
use App\Models\BusTiming;
use DB;
use Illuminate\Http\Request;

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
}