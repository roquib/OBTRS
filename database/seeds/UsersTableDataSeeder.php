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
            'name'       => "Asm Akash",
            'email'      => "akashcseuu026@gmail.com",
            'password'   => Hash::make("123456789"),
        ]);
    }
}
