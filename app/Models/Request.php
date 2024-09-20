<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function main_service()
    {
        return $this->belongsTo(MainServiceType::class, 'main_service_type_id');
    }

    public function sub_service()
    {
        return $this->belongsTo(SubService::class, 'sub_service_id');
    }

    public function scopePaidServices($query)
    {
        return $query->whereHas('service', function ($query) {
            $query->where('fees_type', 'paid');
        });
    }
}
