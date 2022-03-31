<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (app()->environment('local')) {
            Storage::disk('products')->deleteDirectory('/');
            Storage::disk('products')->makeDirectory('/');

            DB::table('products')->insert([
                'name'  => 'Refrigerante 600ML',
                'price' => 6.25,
                'quantity' => 5,
                'quantity_low' => 15,
                'monitor_quantity' => true
            ]);

            Storage::copy('seeders/products/agua-sem-gas.jpg', 'products/pOPr01gsMCqXMUMDjUCV2pAb8IC8CGdvGuu4EgyD.jpg');
            DB::table('products')->insert([
                'name'  => 'Agua sem gás 500ML',
                'price' => 5.00,
                'quantity' => 10,
                'quantity_low' => 5,
                'monitor_quantity' => true,
                'photo' => 'pOPr01gsMCqXMUMDjUCV2pAb8IC8CGdvGuu4EgyD.jpg',
            ]);

            Storage::copy('seeders/products/agua-com-gas.jpg', 'products/Q6FEQ5uGBJdYgmrisNoJTHszRDWlPAPDJddhfiV5.jpg');
            DB::table('products')->insert([
                'name'  => 'Agua com gás 500ML',
                'price' => 5.00,
                'quantity' => 25,
                'quantity_low' => 6,
                'monitor_quantity' => true,
                'photo' => 'Q6FEQ5uGBJdYgmrisNoJTHszRDWlPAPDJddhfiV5.jpg',
            ]);

            DB::table('products')->insert([
                'name'  => 'Fritas',
                'price' => 10,
                'quantity' => 4,
                'quantity_low' => 2,
                'monitor_quantity' => true
            ]);
        }
    }
}
