<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Customer extends Model
{
    use SoftDeletes;
    protected $table = 'customers';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(vehicle::class, 'user_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
