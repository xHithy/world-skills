<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('admins')->count() == 0) {

            DB::table('admins')->insert([
                [
                    'username' => 'admin1',
                    'password' => 'hellouniverse1!',
                    'registered_at' => '2023-02-05T10:20:48.836Z',
                    'last_login' => '2023-02-05T10:20:48.836Z',
                ],
                [
                    'username' => 'admin2',
                    'password' => 'hellouniverse2!',
                    'registered_at' => '2023-02-05T10:20:48.836Z',
                    'last_login' => '2023-02-05T10:20:48.836Z',
                ],
            ]);
        }
    }
}
