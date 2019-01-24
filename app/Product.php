<?php

namespace App;

use App\Used;
use App\Machine;
use App\Ingredient;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * fillable
     *
     * @var string
     */
    protected $fillable = [ 'name' ];

    /**
     * useds
     *
     */
    public function useds()
    {
        return $this->hasMany(Used::class);
    }

    /**
     * ingredients
     *
     */
    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class)
            ->withPivot('quantity');
    }

    /**
     * machines
     *
     */
    public function machines()
    {
        return $this->belongsToMany(Machine::class);
    }
}
