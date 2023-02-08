<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VersionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        if(DB::table('versions')->count() == 0) {
            DB::table('versions')->insert([
                [
                    'game_id' => 1,
                    'version' => 1,
                    'timestamp' => '2023-02-05T10:20:48.836Z',
                    'path' => 'games/demo-game-1/1'
                ],
                [
                    'game_id' => 1,
                    'version' => 2,
                    'timestamp' => '2023-02-05T10:20:48.836Z',
                    'path' => 'games/demo-game-1/2'
                ],
                [
                    'game_id' => 2,
                    'version' => 1,
                    'timestamp' => '2023-02-05T10:20:48.836Z',
                    'path' => 'games/demo-game-2/1'
                ],
            ]);
        }
    }
}
