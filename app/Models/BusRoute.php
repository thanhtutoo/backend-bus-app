<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class BusRoute extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bus_id',
        'bus_stop_id'
    ];
    public function bus_stop()
    {
        return $this->belongsTo(BusStop::class, 'bus_stop_id', 'bus_stop_id');
    }    
    public function bus()
    {
        return $this->belongsTo(Bus::class, 'bus_id', 'bus_id');
    }

    public function bus_timings()
    {
        return $this->hasMany(BusRoute::class,'bus_id', 'bus_id');
    }

}
