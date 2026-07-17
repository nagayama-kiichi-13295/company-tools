<?php

namespace Database\Seeders;

use App\models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = ['家電', '本・雑誌', '衣類', '日用品', '譲ります(無料)', 'その他'];

        foreach ($names as $name) {
            Category::firstOrCreate(['name' => $name ]);
        }
    }
}
