<?php

use Illuminate\Database\Seeder;

class MachinesTableSeeder extends Seeder
{
    protected $machines = [
        [
            'name' => 'Brightly Kávégép'
        ]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->machines as $machine) {
            DB::table('machines')->insert([
                'name'          => $machine['name'],
                'created_at'    => now(),
                'updated_at'    => now()
            ]);
        }
    }
}
