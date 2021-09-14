<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
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
            'name' => 'Fernando',
            'email' => 'fernando@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('123'),
        ]);


        User::create([
            'name' => 'Luis',
            'email' => 'luis@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('123'),
        ]);
    }
}
