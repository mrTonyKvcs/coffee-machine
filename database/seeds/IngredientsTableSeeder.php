<?php

use App\Ingredient;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientsTableSeeder extends Seeder
{
    protected $ingredients = [
        [
            'name'      => 'Kávé',
            'machine'   => [
                [ 'id' => 1, 'in_stock' => 100 ]
            ]
        ],
        [
            'name'      => 'Cukor',
            'machine'   => [
                [ 'id' => 1, 'in_stock' => 100 ]
            ]
        ],
        [
            'name'      => 'Tej',
            'machine'   => [
                [ 'id' => 1, 'in_stock' => 100 ]
            ]
        ]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->ingredients as $i) {
            $ingredient = Ingredient::create([
                'name' => $i['name']
            ]);

            foreach($i['machine'] as $machine) {
                DB::table('ingredient_machine')->insert([
                    'ingredient_id' => $ingredient->id,
                    'machine_id'    => $machine['id'],
                    'in_stock'      => $machine['in_stock']
                ]);
            }
        }
    }
}
