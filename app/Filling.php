<?php

namespace App;

use App\Machine;
use App\Ingredient;
use Illuminate\Database\Eloquent\Model;

class Filling extends Model
{
    /**
     * fillable
     *
     * @var mixed
     */
    protected $fillable = [
        'machine_id', 'ingredient_id', 'filling_quantity'
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
     * ingredient
     *
     */
    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }
}
