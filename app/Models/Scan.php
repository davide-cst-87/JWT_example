<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scan extends Model
{
    use HasFactory;

    protected $fillable = [
        'badge_id',
        'user_id',
        'type',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
