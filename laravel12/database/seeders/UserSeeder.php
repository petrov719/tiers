<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'En3rg0s',
            'email' => 'enenrgs@gmail.com',
            'password' => Hash::make('zipzap51'),
        ]);
    }
}
