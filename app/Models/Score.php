<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Score extends Model
{
    use HasFactory;

    protected $table = 'scores';

    public function player(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
