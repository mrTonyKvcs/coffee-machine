<?php

namespace App\Http\Controllers\Api;

use App\Used;
use App\Machine;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MachinesController extends Controller
{
    /**
     * getMachine
     *
     * @param Machine $machine
     */
    public function getMachine(Machine $machine)
    {
        $products = $this->productsChecking($machine);
        
        return response()->json([
            "machine_id"        => $machine->id,
            "machine_name"      => $machine->name,
            "machine_status"    => $machine->is_service,
            "products"          => $products
        ]);
    }

    /**
     * productsChecking
     *
     * @param mixed $machine
     */
    public function productsChecking($machine) 
    {
        $machineInStock = $machine->ingredients()->select('id', 'name', 'ingredient_machine.in_stock')->get();

        $products = $machine->products;

        foreach($products as $key => $product) {

            $productIngredients = $product->ingredients()->select('id', 'name', 'ingredient_product.quantity')->get();

            foreach($productIngredients as $productIngredient) {
                $machineIngredient = $machineInStock->where('id', $productIngredient->id)->first();

                if ($productIngredient->quantity > $machineIngredient->in_stock) {
                    $products->pull($key);
                }
            }
        }

        return $products;
    }

    /**
     * productMaking
     *
     * @param Machine $machine
     * @param Product $product
     */
    public function productMaking(Machine $machine, Product $product)
    {
        $machineInStock = $machine->ingredients()->select('id', 'name', 'ingredient_machine.in_stock')->get();

        $productIngredients = $product->ingredients()->select('id', 'name', 'ingredient_product.quantity')->get();

        foreach($productIngredients as $productIngredient) {

            $machineIngredient = $machineInStock->where('id', $productIngredient->id)->first();
            
            $ingredientQuantity = ( (int) $machineIngredient->in_stock - (int) $productIngredient->quantity );

            $machine->ingredients()->updateExistingPivot($productIngredient->id, ['in_stock' => $ingredientQuantity]);
        }

        Used::create([
            'machine_id' => $machine->id,
            'product_id' => $product->id
        ]);

        return response(200);
    }
}
