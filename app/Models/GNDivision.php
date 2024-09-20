<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GNDivision extends Model
{
    use HasFactory;

    public function divisionalSecretariat()
    {
        return $this->belongsTo(Division::class,'divisional_secretariat_id');
    }
}
