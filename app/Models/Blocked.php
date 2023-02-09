<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blocked extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'blocked';

    protected $fillable = [
        'user_id',
        'reason'
    ];
}
