<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhaseHistroy extends Model
{
    use HasFactory;

    public function request()
    {
        return $this->belongsTo(Request::class, 'request_id');
    }
}
