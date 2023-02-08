<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Game extends Model
{
    use HasFactory;

    protected $table = 'games';

    public function author(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'author_id');
    }

    public function score(): HasMany
    {
        return $this->hasMany(Score::class, 'game_id', 'id');
    }

    public function latest(): HasOne
    {
        return $this->hasOne(Version::class, 'version', 'id')->ofMany('version', 'max');
    }
}
