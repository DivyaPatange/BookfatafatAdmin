<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceTimeSlot extends Model
{
    use HasFactory;

    protected $table = "service_time_slots";

    protected $fillable = ['vendor_id', 'service_id', 'available_date_id', 'from_time', 'to_time', 'duration'];
}
