<?php

namespace App\Console\Commands;

use App\Used;
use App\Machine;
use App\Product;
use App\Service;
use Illuminate\Console\Command;

class SellingInformations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coffee:selling-informations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Eladási információk';

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

        $lastService = Service::where('machine_id', $machine->id)->orderBy('created_at')->get()->last();

        $usedProducts = Used::where('created_at', '>', $lastService->created_at)->get()->groupBy('product_id');

        foreach($usedProducts as $usedProduct) {
            $product = Product::where('id', $usedProduct->first()->product_id)->first();
            $productCount = $usedProduct->count();
            $ingredients = $this->getIngredients($product);
            foreach($ingredients as $ingredient) {
                $usedIngredients[] = [ $ingredient->name => $ingredient->quantity];
            }
            $selling[] = [ 'name' => $product->name, 'quantity' => $productCount ];
        }

        $sumIngredients = [];

        if(isset($usedIngredients)) {
            foreach($usedIngredients as $ingredients) {
                foreach($ingredients as $key => $value) {
                    if (isset($sumIngredients[$key])) {
                        $sumIngredients[$key] += $value;
                    } else {
                        $sumIngredients[$key] = $value;
                    }
                }
            }
        }


        if ($sumIngredients) {
            $this->line("\n $machine->name utolsó szervizelése óta eladott termékek alapanyagai:");

            foreach($sumIngredients as $name => $quantity) {
                $this->info("$name: $quantity egység");
            }
        }


        if( isset($selling) ) { 
            $this->line("\n $machine->name utolsó szervizelése óta eladott termékek:");

            $headers = ['Neve', 'Mennyiség(db)'];

            $this->table($headers, $selling);
        }
        else {
            $this->info("Nincs eladott termék");
        }
    }

    /**
     * getIngredients
     *
     * @param mixed $product
     */
    public function getIngredients($product)
    {
        $ingredients = $product->ingredients()->select('id', 'name', 'ingredient_product.quantity')->get();

        return $ingredients;
    }

    /**
     * getMachine
     *
     */
    protected function getMachine()
    {
        $machines = Machine::all()->pluck('name', 'id')->toArray();

        $machineName = $this->choice('Válasszon gépet az eladások megtekintéséhez!', $machines, 1);

        return Machine::where('name', $machineName)->first();
    }
}
