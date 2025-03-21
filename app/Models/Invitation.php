<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;

    protected $fillable = ['company_id', 'email', 'token', 'role'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}