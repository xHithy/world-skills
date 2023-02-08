<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        if(DB::table('users')->count() == 0){

            DB::table('users')->insert([
                [
                    'username' => 'player1',
                    'password' => 'helloworld1!',
                    'status' => 'active',
                    'registered_at' => '2023-02-05T10:20:48.836Z',
                    'last_login' => '2023-02-05T10:20:48.836Z',
                ],
                [
                    'username' => 'player2',
                    'password' => 'helloworld2!',
                    'status' => 'active',
                    'registered_at' => '2023-02-05T10:20:48.836Z',
                    'last_login' => '2023-02-05T10:20:48.836Z',
                ],
                [
                    'username' => 'dev1',
                    'password' => 'hellobyte1!',
                    'status' => 'active',
                    'registered_at' => '2023-02-05T10:20:48.836Z',
                    'last_login' => '2023-02-05T10:20:48.836Z',
                ],
                [
                    'username' => 'dev2',
                    'password' => 'hellobyte2!',
                    'status' => 'active',
                    'registered_at' => '2023-02-05T10:20:48.836Z',
                    'last_login' => '2023-02-05T10:20:48.836Z',
                ],
            ]);
        }
    }
}
