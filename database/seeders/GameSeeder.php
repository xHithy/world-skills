<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        if(DB::table('games')->count() == 0) {
            DB::table('games')->insert([
                [
                    'title' => 'Demo Game 1',
                    'slug' => 'demo-game-1',
                    'description' => 'This is demo game 1',
                    'author_id' => 3,
                    'status' => 'active',
                ],
                [
                    'title' => 'Demo Game 2',
                    'slug' => 'demo-game-2',
                    'description' => 'This is demo game 2',
                    'author_id' => 4,
                    'status' => 'active',
                ],
            ]);
        }
    }
}
