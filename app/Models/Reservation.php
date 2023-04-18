<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Reservation extends Model
{
    use SoftDeletes;
    protected $table = 'reservations';

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class, 'payment_type_id');
    }

    public function source()
    {
        return $this->belongsTo(Source::class, 'source_id');
    }

    public function routeType()
    {
        return $this->belongsTo(RouteType::class, 'route_type_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function subCustomers()
    {
        return $this->belongsToMany(Customer::class, 'reservations_customers', 'reservation_id', 'customer_id')
            ->selectRaw('customers.*, reservations_customers.*');
    }

    public function subPaymentTypes()
    {
        return $this->belongsToMany(PaymentType::class, 'reservations_payments_types', 'reservation_id', 'payment_type_id')
            ->selectRaw('payment_types.*, reservations_payments_types.*');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
