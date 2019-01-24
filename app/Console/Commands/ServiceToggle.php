<?php

namespace App\Console\Commands;

use App\Machine;
use App\Service;
use Illuminate\Console\Command;

class ServiceToggle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coffee:service-toggle {machine_id=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kávégép szervíz üzemmódba helyezése';

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
        $machine = Machine::find($this->argument('machine_id'));

        if ($this->confirm('Jelenleg a ' . $machine->name .  ' gép státusza: ' . ($machine->is_service == 0 ? ' ÜZEMBEN. Szeretnéd szervíz üzemmódba kapcsolni?' : ' SZERVÍZ ALATT. Szeretnéd üzembe helyezni a gépet?'))) {

            $machine->update([ 'is_service' => $machine->is_service == 0 ? 1 : 0 ]);
            $message = $machine->is_service == 0 ? ' újra üzemel!' : ' szervíz üzemmódba került!';
            $this->info($machine->name . $message);
            
            if ($machine->is_service == 1) {
                Service::create([
                    'machine_id' => $machine->id,
                    'service_at' => now()
                ]);
            }
        }
    }
}
