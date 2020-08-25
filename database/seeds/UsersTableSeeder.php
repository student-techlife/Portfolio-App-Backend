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
            'name' => 'Lars',
            'lastname' => 'van der Niet',
            'email' => 'test@test.nl',
            'password' => bcrypt('password'),
        ]);
        DB::table('users')->insert([
            'name' => 'Test',
            'lastname' => 'nog een Tester',
            'email' => 'l@g.com',
            'password' => bcrypt('password'),
        ]);
    }
}
