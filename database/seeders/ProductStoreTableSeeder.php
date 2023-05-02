<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductStore;

class ProductStoreTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        ProductStore::factory()
            ->count(50)
            ->create();
    }
}
