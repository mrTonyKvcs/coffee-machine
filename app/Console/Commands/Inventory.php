<?php

namespace App\Console\Commands;

use App\Machine;
use App\Ingredient;
use Illuminate\Console\Command;

class Inventory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coffee:inventory {machine_id=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Készlet listázása';

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

        $this->line("\n $machine->name alapanyag leltár készlete:");

        $headers = ['Neve', 'Mennyiség'];

        $ingredients = $machine->ingredients()->select('name', 'ingredient_machine.in_stock')->get()->toArray();

        $this->table($headers, $ingredients);
    }

    /**
     * getMachine
     *
     */
    protected function getMachine()
    {
        $machines = Machine::all()->pluck('name', 'id')->toArray();

        $machineName = $this->choice('Melyik gép tárolóit szeretnéd ellenőrizni? ', $machines, 1);

        return Machine::where('name', $machineName)->first();
    }
}
