<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Game extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'games';

    protected $fillable = [
        'title',
        'description',
        'thumbnail',
        'slug',
        'author_id',
        'active'
    ];

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
        return $this->hasOne(Version::class, 'game_id', 'id')->ofMany('version', 'max');
    }
}
