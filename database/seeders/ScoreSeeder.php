<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        if(DB::table('scores')->count() == 0) {
            DB::table('scores')->insert([
                [
                    'user_id' => 1,
                    'game_id' => 1,
                    'version' => 1,
                    'score' => 10,
                    'timestamp' => '2023-02-05T10:20:48.836Z',
                ],
                [
                    'user_id' => 1,
                    'game_id' => 1,
                    'version' => 1,
                    'score' => 15,
                    'timestamp' => '2023-02-05T10:20:48.836Z',
                ],
                [
                    'user_id' => 1,
                    'game_id' => 1,
                    'version' => 2,
                    'score' => 12,
                    'timestamp' => '2023-02-05T10:20:48.836Z',
                ],
                [
                    'user_id' => 2,
                    'game_id' => 1,
                    'version' => 2,
                    'score' => 20,
                    'timestamp' => '2023-02-05T10:20:48.836Z',
                ],
                [
                    'user_id' => 2,
                    'game_id' => 2,
                    'version' => 1,
                    'score' => 30,
                    'timestamp' => '2023-02-05T10:20:48.836Z',
                ],
                [
                    'user_id' => 3,
                    'game_id' => 1,
                    'version' => 2,
                    'score' => 1000,
                    'timestamp' => '2023-02-05T10:20:48.836Z',
                ],
                [
                    'user_id' => 3,
                    'game_id' => 1,
                    'version' => 2,
                    'score' => -300,
                    'timestamp' => '2023-02-05T10:20:48.836Z',
                ],
                [
                    'user_id' => 4,
                    'game_id' => 1,
                    'version' => 2,
                    'score' => 5,
                    'timestamp' => '2023-02-05T10:20:48.836Z',
                ],
                [
                    'user_id' => 4,
                    'game_id' => 2,
                    'version' => 1,
                    'score' => 200,
                    'timestamp' => '2023-02-05T10:20:48.836Z',
                ],
            ]);
        }
    }
}
