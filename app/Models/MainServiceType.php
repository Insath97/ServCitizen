<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainServiceType extends Model
{
    use HasFactory;

    public function service_type()
    {
        return $this->belongsTo(ServiceType::class, 'service_type_id');
    }
}
