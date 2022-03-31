<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (app()->environment('local')) {
            DB::table('rooms')->insert([
                'number' => 101,
                'price' => 20,
                'price_per_additional_hour' => 15
            ]);

            DB::table('rooms')->insert([
                'number' => 102,
                'price' => 20,
                'price_per_additional_hour' => 15
            ]);

            DB::table('rooms')->insert([
                'number' => 103,
                'price' => 20,
                'price_per_additional_hour' => 15
            ]);

            DB::table('rooms')->insert([
                'number' => 104,
                'price' => 30,
                'price_per_additional_hour' => 20
            ]);

            DB::table('rooms')->insert([
                'number' => 105,
                'price' => 30,
                'price_per_additional_hour' => 20
            ]);

            DB::table('rooms')->insert([
                'number' => 201,
                'price' => 30,
                'price_per_additional_hour' => 20
            ]);

            DB::table('rooms')->insert([
                'number' => 202,
                'price' => 40,
                'price_per_additional_hour' => 20
            ]);

            DB::table('rooms')->insert([
                'number' => 203,
                'price' => 85,
                'price_per_additional_hour' => 35
            ]);

            DB::table('rooms')->insert([
                'number' => 204,
                'price' => 110,
                'price_per_additional_hour' => 50
            ]);

            DB::table('rooms')->insert([
                'number' => 205,
                'price' => 110,
                'price_per_additional_hour' => 50
            ]);
        }
    }
}
