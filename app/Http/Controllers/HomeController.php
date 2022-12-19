<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Hotel;
use App\Models\BookingForm;
use App\Models\ContactForm;
use App\Models\Vehicle;
use App\Models\Service;
use App\Models\Reservation;
use App\Models\Therapist;
use Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $bookingFormCount = BookingForm::count();
        $reservationCount = Reservation::count();
        $vehicleCount = Vehicle::count();

        $dashboard = array('bookingFormCount' => $bookingFormCount, 'reservationCount' => $reservationCount, 'vehicleCount' => $vehicleCount);

        return view('home')->with($dashboard);
    }
}
