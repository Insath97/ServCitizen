<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function divisionalSecretariat()
    {
        return $this->belongsTo(Division::class);
    }

    public function gndivison()
    {
        return $this->belongsTo(GNDivision::class, 'gn_division_id');
    }

    public function requestServices()
    {
        return $this->hasMany(Request::class);
    }
}
