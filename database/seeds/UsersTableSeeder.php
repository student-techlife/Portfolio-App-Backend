<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Lars van der Niet',
            'email' => 'test@test.nl',
            'password' => bcrypt('password'),
        ]);
    }
}
