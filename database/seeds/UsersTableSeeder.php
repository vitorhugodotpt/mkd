<?php

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'mkd_admin@yopmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('123456'),
            'api_token' => Str::random(60),
        ]);
    }
}
