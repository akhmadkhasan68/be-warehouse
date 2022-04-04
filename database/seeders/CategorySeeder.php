<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Dingin, Beku, Pabrik, Stock
        Category::create([
            "name" => "Dingin"
        ]);

        Category::create([
            "name" => "Beku"
        ]);

        Category::create([
            "name" => "Pabrik"
        ]);

        Category::create([
            "name" => "Stock"
        ]);
    }
}
