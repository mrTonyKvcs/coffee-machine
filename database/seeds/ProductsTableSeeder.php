<?php

use App\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    protected $products = [
        [
            'name'          => 'Espresso',
            'ingredients'   => [
                [ 'id' => 1, 'quantity'  => 10 ]
            ],
            'machines'      => [
                [ 'id' => 1 ]
            ]
        ],
        [
            'name' => 'Cappucino',
            'ingredients'   => [
                [ 'id' => 1, 'quantity'  => 20 ],
                [ 'id' => 3, 'quantity'  => 10 ]
            ],
            'machines'      => [
                [ 'id' => 1 ]
            ]
        ],
        [
            'name' => 'Latte',
            'ingredients'   => [
                [ 'id' => 1, 'quantity'  => 30 ],
                [ 'id' => 2, 'quantity'  => 20 ],
                [ 'id' => 3, 'quantity'  => 10 ]
            ],
            'machines'      => [
                [ 'id' => 1 ]
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
        foreach($this->products as $p) {
            $product = Product::create([
                'name' => $p['name']
            ]);

            foreach($p['ingredients'] as $ingredient) {
                DB::table('ingredient_product')->insert([
                    'ingredient_id' => $ingredient['id'],
                    'product_id'    => $product->id,
                    'quantity'      => $ingredient['quantity']
                ]);
            }

            foreach($p['machines'] as $machine) {
                DB::table('machine_product')->insert([
                    'machine_id' => $machine['id'],
                    'product_id' => $product->id
                ]);
            }
        }
    }
}
