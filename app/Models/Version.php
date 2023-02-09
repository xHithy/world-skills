<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Version extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'versions';

    protected $fillable = [
        'game_id',
        'version',
        'timestamp',
        'thumbnail',
        'path'
    ];

    public function game() {
        return $this->hasOne(Game::class, 'id', 'game_id');
    }
}
