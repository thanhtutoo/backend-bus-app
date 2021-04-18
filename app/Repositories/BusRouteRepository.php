<?php

namespace App\Repositories;

use App\Http\Requests\BusRouteRequest;
use App\Interfaces\BusRouteInterface;
use App\Traits\ResponseAPI;
use App\Models\BusRoute;
use App\Models\BusTiming;
use DB;
use Illuminate\Http\Request;

class BusRouteRepository implements BusRouteInterface
{
    // Use ResponseAPI Trait in this repository
    use ResponseAPI;

    public function getAllBusRoute()
    {
        try {
            $bus_routes = BusRoute::all();
            return $this->success("All BusRoutes", $bus_routes);
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function getBusRouteById($id)
    {
        try {
            $bus_route = BusRoute::find($id);
            
            // Check the busRoute
            if(!$bus_route) return $this->error("No bus_route with ID $id", 404);

            return $this->success("BusRoute Detail", $bus_route);
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function requestBusRoute(BusRouteRequest $request, $id = null)
    {
        DB::beginTransaction();
        try {
            // If bus exists when we find it
            // Then update the busroute
            // Else create the new one.
            $bus_route = $id ? BusRoute::find($id) : new BusRoute;

            // Check the busroute
            if($id && !$bus_route) return $this->error("No busRoute with ID $id", 404);

            $bus_route->bus_stop_id = $request->bus_stop_id;
            $bus_route->bus_id = $request->bus_id;
            // Save the busroute
            $bus_route->save();

            DB::commit();
            return $this->success(
                $id ? "Busroute updated"
                    : "Busroute created",
                $bus_route, $id ? 200 : 201);
        } catch(\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), 422);
        }
    }

    public function deleteBusRoute($id)
    {
        DB::beginTransaction();
        try {
            $bus_route = BusRoute::find($id);

            // Check the busroute
            if(!$bus_route) return $this->error("No busRoute with ID $id", 404);

            // Delete the busroute
            $bus_route->delete();

            DB::commit();
            return $this->success("BusRoute deleted", $bus_route);
        } catch(\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }
}