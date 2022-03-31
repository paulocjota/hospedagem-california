<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (app()->environment('local')) {
            DB::table('users')->insert([
                'name'              => 'Admin',
                'email'             => 'admin@admin.com',
                'email_verified_at' => now(),
                'password'          => bcrypt('admin'),
                'remember_token'    => Str::random(10),
            ]);

            DB::table('users')->insert([
                'name'              => 'User Admin',
                'email'             => 'useradmin@admin.com',
                'email_verified_at' => now(),
                'password'          => bcrypt('useradmin'),
                'remember_token'    => Str::random(10),
            ]);

            DB::table('users')->insert([
                'name'              => 'User Operator',
                'email'             => 'useroperator@admin.com',
                'email_verified_at' => now(),
                'password'          => bcrypt('useroperator'),
                'remember_token'    => Str::random(10),
            ]);
        }
    }
}
