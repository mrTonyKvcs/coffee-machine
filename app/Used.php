<?php

namespace App;

use App\Machine;
use App\Product;
use Illuminate\Database\Eloquent\Model;

class Used extends Model
{
    /**
     * fillable
     *
     * @var mixed
     */
    protected $fillable = [
        'machine_id', 'product_id'
    ];

    /**
     * machine
     *
     */
    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }

    /**
     * product
     *
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
