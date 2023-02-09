<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'username',
        'password',
        'registered_at',
        'last_login'
    ];

    public function blocked(): HasOne
    {
        return $this->hasOne(Blocked::class, 'user_id', 'id');
    }

    public function highscore(): HasOne
    {
        return $this->hasOne(Score::class, 'user_id', 'id')->ofMany('score', 'max');
    }
}
