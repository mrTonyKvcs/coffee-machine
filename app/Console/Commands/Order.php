<?php

namespace App\Console\Commands;

use App\Used;
use App\Machine;
use Illuminate\Console\Command;

class Order extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coffee:order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rendelés';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $machine = $this->getMachine();

        if($machine->is_service == 1) {
            $this->line('Sajnáljuk de ez a gépünk jelenleg nem üzemel!');
            exit();
        }

        $this->chooseProduct($machine);
    }

    /**
     * getMachine
     *
     */
    protected function getMachine()
    {
        $machines = Machine::all()->pluck('name', 'id')->toArray();

        $machineName = $this->choice('Melyik gépből szeretnél rendelni', $machines, 1);

        return Machine::where('name', $machineName)->first();
    }

    /**
     * chooseProduct
     *
     * @param mixed $machine
     */
    protected function chooseProduct($machine)
    {
        $products = $machine->products()->pluck('name', 'id')->toArray();

        $productName = $this->choice('Válaszd ki a terméket!', $products, 1);

        $product = $machine->products()->where('name', $productName)->first();

        $productIngredients = $product->ingredients()->select('id', 'name', 'ingredient_product.quantity')->get();

        $machineInStock = $machine->ingredients()->select('id', 'name', 'ingredient_machine.in_stock')->get();

        $this->productChecking($product, $productIngredients, $machineInStock);

        $this->productMaking($machine, $product, $productIngredients, $machineInStock);
    }

    /**
     * productChecking
     *
     * @param mixed $product
     * @param mixed $productIngredients
     * @param mixed $machineInStock
     */
    protected function productChecking($product, $productIngredients, $machineInStock)
    {
        foreach($productIngredients as $productIngredient) {

            $machineIngredient = $machineInStock->where('id', $productIngredient->id)->first();
            
            if ($productIngredient->quantity > $machineIngredient->in_stock) {
                $this->line("Jelenleg a $product->name nem rendelhető!");
                exit();
            }
        }

        return $this->info("Készül a $product->name !");
    }

    /**
     * productMaking
     *
     * @param mixed $machine
     * @param mixed $product
     * @param mixed $productIngredients
     * @param mixed $machineInStock
     */
    protected function productMaking($machine, $product, $productIngredients, $machineInStock)
    {
        foreach($productIngredients as $productIngredient) {

            $machineIngredient = $machineInStock->where('id', $productIngredient->id)->first();
            
            $ingredientQuantity = ( (int) $machineIngredient->in_stock - (int) $productIngredient->quantity );

            $machine->ingredients()->updateExistingPivot($productIngredient->id, ['in_stock' => $ingredientQuantity]);
        }

        Used::create([
            'machine_id' => $machine->id,
            'product_id' => $product->id
        ]);

        return $this->info("Elkészült a $product->name! Egészségedre!");
    }
}
