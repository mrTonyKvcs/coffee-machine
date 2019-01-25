<?php

namespace App;

use App\Used;
use App\Product;
use App\Filling;
use App\Service;
use App\Ingredient;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    /**
     * fillable
     *
     * @var string
    */
    protected $fillable = [ 'name', 'is_service' ];

    /**
     * fillings
     *
     */
    public function fillings()
    {
        return $this->hasMany(Filling::class);
    }

    /**
     * ingredients
     *
     */
    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class)
            ->withPivot('in_stock');
    }

    /**
     * products
     *
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    /**
     * services
     *
     */
    public function services()
    {
        return $this->hasMany(Service::class);
    }

    /**
     * useds
     *
     */
    public function useds()
    {
        return $this->hasMany(Used::class);
    }

}
