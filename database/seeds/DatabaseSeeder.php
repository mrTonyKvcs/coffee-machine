<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * truncateTo
     *
     * @var mixed
     */
    protected $truncateTo = [
        'ingredients',
        'products',
        'machines',
        'ingredient_product',
        'ingredient_machine',
        'machine_product'
    ];

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->truncateTo as $table) {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0');
            DB::table($table)->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        }

        $this->call(IngredientsTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(MachinesTableSeeder::class);
    }
}
