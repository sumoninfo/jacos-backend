<?php

use App\User;
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
        //Create admin user
        User::create([
            'name'     => "Admin",
            'email'    => "admin@gmail.com",
            'phone'    => "01714648853",
            'password' => Hash::make(12345678),
        ]);

        //Create dummy users data
        factory(User::class, 50)->create();
    }
}
