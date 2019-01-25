<?php

namespace App\Console\Commands;

use App\Filling;
use App\Machine;
use App\Service;
use App\Ingredient;
use Illuminate\Console\Command;

class AddIngredient extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coffee:add-ingredient';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tárolók feltöltése';

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

        if ($machine->is_service == 0) {

            if ($this->confirm('Jelenleg a ' . $machine->name .  ' gép státusza: ÜZEMBEN. Szeretnéd szervíz üzemmódba kapcsolni?')) {

                $this->serviceToggle($machine);
                $this->addIngredient($machine);

                if ($this->confirm('Jelenleg a ' . $machine->name .  ' gép státusza: SZERVÍZ ALATT. Szeretnéd üzembe helyezni a gépet?')) {

                    $this->serviceToggle($machine);
                    exit();
                }
            }
            exit();
        }

        if ($machine->is_service == 1) {
            $this->addIngredient($machine);
            if ($this->confirm('Jelenleg a ' . $machine->name .  ' gép státusza: SZERVÍZ ALATT. Szeretnéd üzembe helyezni a gépet?')) {

                $this->serviceToggle($machine);
            }
        }
    }

    /**
     * serviceToggle
     *
     */
    protected function serviceToggle($machine)
    {
        $machine->update([ 'is_service' => $machine->is_service == 0 ? 1 : 0 ]);
        $message = $machine->is_service == 0 ? ' újra üzemel!' : ' szervíz üzemmódba került!';
        Service::create([
            'machine_id' => $machine->id,
            'service_at' => now()
        ]);
        $this->info($machine->name . $message);
    }

    /**
     * getMachine
     *
     */
    protected function getMachine()
    {
        $machines = Machine::all()->pluck('name', 'id')->toArray();

        $machineName = $this->choice('Melyik gépet szeretnéd feltölteni? ', $machines, 1);

        return Machine::where('name', $machineName)->first();
    }

    /**
     * addIngredient
     *
     */
    protected function addIngredient($machine)
    {
        $ingredients = $machine->ingredients()->pluck('name', 'id')->toArray();

        $name = $this->choice('Válaszd ki a feltölteni kívánt tárolót!', $ingredients, 1);

        $ingredient = $machine->ingredients()->where('name', $name)->first();

        $quantity = $machine->ingredients()->where('id', $ingredient->id)->select('ingredient_machine.in_stock')->first();

        $fillingQuantity = ( 100 - (int) $quantity->in_stock );

        if ($fillingQuantity <= 0) {
            $this->line($machine->name . '  ' . $ingredient->name . ' tárolója fullon van!');
            exit();
        }

        $machine->ingredients()->updateExistingPivot($ingredient->id, ['in_stock' => 100]);

        Filling::create([
            'machine_id'        => $machine->id,
            'ingredient_id'     => $ingredient->id,
            'filling_quantity'  => $fillingQuantity,
            'filling_at'        => now()
        ]);

        $this->line('Sikeresen feltöltötted a ' . $ingredient->name . ' tárolót!');
    }
}
