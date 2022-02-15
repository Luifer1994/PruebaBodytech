<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $typeUsers = ["Admin", "Client"];
        foreach ($typeUsers as $value) {
            DB::table('type_users')->insert([
                "name" => $value,
                "created_at" =>  now(),
                "updated_at" =>  now(),
            ]);
        }

        User::factory(10)->create();
        Product::factory(10)->create();
    }
}