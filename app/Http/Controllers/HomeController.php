<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Hotel;
use App\Models\ContactForm;
use App\Models\BookingForm;
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
        try {

            $customerCount = Customer::count();
            $contactFormCount = ContactForm::count();
            $bookingFormCount = BookingForm::count();

            $dashboard = array('customerCount' => $customerCount, 'contactFormCount' => $contactFormCount, 'bookingFormCount' => $bookingFormCount);

            return view('home')->with($dashboard);
        }
        catch (\Throwable $th) {
            throw $th;
        }
    }
}
