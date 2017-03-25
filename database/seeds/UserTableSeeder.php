<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Ahmad Arif',
            'email' => 'ahmadarif@mail.com',
            'password' => app('hash')->make('123'),
            'remember_token' => str_random(10),
        ]);
    }
}
