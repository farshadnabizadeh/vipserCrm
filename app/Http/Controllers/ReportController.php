<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\ReservationPaymentType;
use App\Models\ReservationComission;
use App\Models\ReservationTherapist;
use App\Models\ReservationService;
use App\Models\Therapist;
use App\Models\Vehicle;
use App\Models\Source;
use App\Models\Guide;
use App\Models\Hotel;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function reservationReport(Request $request)
    {
        try {

            $start = $request->input('startDate');
            $end = $request->input('endDate');

            $therapistAll = ReservationTherapist::select('therapists.*', DB::raw('therapist_id, sum(piece) as therapistCount'))
            ->leftJoin('therapists', 'reservations_therapists.therapist_id', '=', 'therapists.id')
            ->whereBetween('reservations_therapists.created_at', [date('Y-m-d', strtotime($start))." 00:00:00", date('Y-m-d', strtotime($end))." 23:59:59"])
            ->groupBy('therapist_id')
            ->get();

            $serviceAll = ReservationService::select('services.*', DB::raw('service_id, sum(piece) as serviceCount'))
            ->leftJoin('services', 'reservations_services.service_id', '=', 'services.id')
            ->whereBetween('reservations_services.created_at', [date('Y-m-d', strtotime($start))." 00:00:00", date('Y-m-d', strtotime($end))." 23:59:59"])
            ->groupBy('service_id')
            ->get();

            $data = array('therapistAll' => $therapistAll, 'serviceAll' => $serviceAll, 'start' => $start, 'end' => $end);
            return view('admin.reports.reservation_report')->with($data);

        }
        catch (\Throwable $th) {
            throw $th;
        }
    }

    public function sourceReport(Request $request)
    {
        try {

            $data = Source::select("sources.*", \DB::raw("(SELECT count(*) FROM reservations a WHERE a.source_id = sources.id) as aCount"))->get();

            return json_encode($data);
        }
        catch (\Throwable $th) {
            throw $th;
        }
    }

    public function therapistReport(Request $request)
    {
        try {

            $data = Therapist::select("therapists.*", \DB::raw("(SELECT sum(piece) FROM reservations_therapists a WHERE a.therapist_id = therapists.id) as aCount"))->get();

            return json_encode($data);
        }
        catch (\Throwable $th) {
            throw $th;
        }
    }

    public function comissionReport(Request $request)
    {
        try {

            $start = $request->input('startDate');
            $end = $request->input('endDate');

            $hotelComissions = ReservationComission::select('hotels.*', DB::raw('hotel_id, sum(comission_price) as totalPrice'))
            ->leftJoin('hotels', 'reservations_comissions.hotel_id', '=', 'hotels.id')
            ->whereBetween('reservations_comissions.created_at', [date('Y-m-d', strtotime($start))." 00:00:00", date('Y-m-d', strtotime($end))." 23:59:59"])
            ->whereNull('reservations_comissions.guide_id')
            ->groupBy('hotel_id')
            ->get();

            $guideComissions = ReservationComission::select('guides.*', DB::raw('guide_id, sum(comission_price) as totalPrice'))
            ->leftJoin('guides', 'reservations_comissions.guide_id', '=', 'guides.id')
            ->whereBetween('reservations_comissions.created_at', [date('Y-m-d', strtotime($start))." 00:00:00", date('Y-m-d', strtotime($end))." 23:59:59"])
            ->whereNull('reservations_comissions.hotel_id')
            ->groupBy('guide_id')
            ->get();

            $data = array('hotelComissions' => $hotelComissions, 'guideComissions' => $guideComissions, 'start' => $start, 'end' => $end);

            return view('admin.reports.comission_report')->with($data);
        }
        catch (\Throwable $th) {
            throw $th;
        }
    }

    public function vehicleReport(Request $request)
    {
        try {

            $data = Vehicle::select("vehicles.*", \DB::raw("(SELECT count(*) FROM reservations a WHERE a.vehicle_id = vehicles.id) as aCount"))->get();

            return json_encode($data);
        }
        catch (\Throwable $th) {
            throw $th;
        }
    }

    public function paymentReport(Request $request)
    {
        try {

            $start = $request->input('startDate');
            $end = $request->input('endDate');

            //cash tl
            $cashTl = ReservationPaymentType::where('reservations_payments_types.payment_type_id', '1')
                ->whereBetween('reservations_payments_types.created_at', [date('Y-m-d', strtotime($start))." 00:00:00", date('Y-m-d', strtotime($end))." 23:59:59"])
                ->sum("payment_price");

            //cash euro
            $cashEur = ReservationPaymentType::where('reservations_payments_types.payment_type_id', '2')
                ->whereBetween('reservations_payments_types.created_at', [date('Y-m-d', strtotime($start))." 00:00:00", date('Y-m-d', strtotime($end))." 23:59:59"])
                ->sum("payment_price");

            //cash usd
            $cashUsd = ReservationPaymentType::where('reservations_payments_types.payment_type_id', '3')
                ->whereBetween('reservations_payments_types.created_at', [date('Y-m-d', strtotime($start))." 00:00:00", date('Y-m-d', strtotime($end))." 23:59:59"])
                ->sum("payment_price");

            //cash pound
            $cashPound = ReservationPaymentType::where('reservations_payments_types.payment_type_id', '4')
                ->whereBetween('reservations_payments_types.created_at', [date('Y-m-d', strtotime($start))." 00:00:00", date('Y-m-d', strtotime($end))." 23:59:59"])
                ->sum("payment_price");

            //free
            $free = ReservationPaymentType::where('reservations_payments_types.payment_type_id', '5')
                ->whereBetween('reservations_payments_types.created_at', [date('Y-m-d', strtotime($start))." 00:00:00", date('Y-m-d', strtotime($end))." 23:59:59"])
                ->sum("payment_price");

            //ziraat kk euro
            $ziraatKkEuro = ReservationPaymentType::where('reservations_payments_types.payment_type_id', '8')
                ->whereBetween('reservations_payments_types.created_at', [date('Y-m-d', strtotime($start))." 00:00:00", date('Y-m-d', strtotime($end))." 23:59:59"])
                ->sum("payment_price");

            //ziraat kk tl
            $ziraatKkTl = ReservationPaymentType::where('reservations_payments_types.payment_type_id', '9')
                ->whereBetween('reservations_payments_types.created_at', [date('Y-m-d', strtotime($start))." 00:00:00", date('Y-m-d', strtotime($end))." 23:59:59"])
                ->sum("payment_price");
                
            //ziraat kk usd
            $ziraatKkUsd = ReservationPaymentType::where('reservations_payments_types.payment_type_id', '10')
                ->whereBetween('reservations_payments_types.created_at', [date('Y-m-d', strtotime($start))." 00:00:00", date('Y-m-d', strtotime($end))." 23:59:59"])
                ->sum("payment_price");

            $totalData = array('cashTl' => $cashTl, 'cashEur' => $cashEur, 'cashUsd' => $cashUsd, 'cashPound' => $cashPound, 'free' => $free, 'ziraatKkEuro' => $ziraatKkEuro, 'ziraatKkTl' => $ziraatKkTl, 'ziraatKkUsd' => $ziraatKkUsd, 'start' => $start, 'end' => $end);

            return view('admin.reports.payment_report')->with($totalData);
        }
        catch (\Throwable $th) {
            throw $th;
        }
    }
    
}