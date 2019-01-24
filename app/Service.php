<?php

namespace App;

use App\Machine;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    /**
     * fillable
     *
     * @var string
    */
    protected $fillable = [ 'machine_id', 'service_at' ];

    /**
     * machine
     *
     */
    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }
}
