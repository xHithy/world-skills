<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'token',
        'expiring_at'
    ];

    public function blocked() {
        return $this->hasOne(Blocked::class, 'user_id', 'user_id');
    }
}
