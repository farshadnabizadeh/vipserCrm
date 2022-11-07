<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Vehicle extends Model
{
    use SoftDeletes;
    protected $table = 'vehicles';

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
