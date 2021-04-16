<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class BusStop extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey = 'bus_stop_id';
    protected $fillable = [
        'bus_stop_id',
        'bus_stop_name',
        'lat',
        'lng',
        'postal_code',
    ];

    public function bus_routes()
    {
        return $this->hasMany(BusRoute::class,'bus_stop_id', 'bus_stop_id');
    }  
    public function bus_timings()
    {
        return $this->hasMany(BusTiming::class,'bus_stop_id', 'bus_stop_id');
    }

}
