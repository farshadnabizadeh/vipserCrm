<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class SalesPerson extends Model
{
    use SoftDeletes;
    protected $table = 'sales_persons';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
