<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusHistory extends Model
{
    use HasFactory;

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function request()
    {
        return $this->belongsTo(Request::class, 'request_id');
    }
}
