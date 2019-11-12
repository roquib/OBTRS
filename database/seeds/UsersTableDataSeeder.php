<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'       => "Abdur Roquib",
            'email'      => "roquib@gmail.com",
            'type'       => 'admin',
            'password'   => Hash::make("123456789"),
        ]);
    }
}
