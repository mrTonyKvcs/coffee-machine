<?php

namespace App;

use App\Filling;
use App\Product;
use App\Machine;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    /**
     * fillable
     *
     * @var string
     */
    protected $fillable = [ 'name' ];

    /**
     * hidden
     *
     * @var string
     */
    protected $hidden = [ 'pivot' ];

    /**
     * fillings
     *
     */
    public function fillings()
    {
        return $this->hasMany(Filling::class);
    }

    /**
     * products
     *
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    protected function machine()
    {
        return $this->belongsTo(Machine::class);
    }
    
}
