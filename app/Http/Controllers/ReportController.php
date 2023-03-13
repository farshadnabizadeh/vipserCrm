<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\ReservationPaymentType;
use App\Models\Vehicle;
use App\Models\Source;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $start = $request->input('startDate');
        $end = $request->input('endDate');

        $reservations = Reservation::whereBetween('reservations.reservation_date', [date('Y-m-d', strtotime($start)) . " 00:00:00", date('Y-m-d', strtotime($end)) . " 23:59:59"])->get();

        $data = array('reservations' => $reservations, 'start' => $start, 'end' => $end);
        return view('admin.reports.index')->with($data);
    }

    public function reservationReport(Request $request)
    {
        try {

            $start = $request->input('startDate');
            $end = $request->input('endDate');
            $sourcesSelect = Source::all();
            $selectedSources = $request->input('selectedSource', []);
            $user = auth()->user();

            $reservationsAll = Reservation::select('reservations.*', DB::raw('count(id) as reservationCount'))
                ->whereBetween('reservations.reservation_date', [date('Y-m-d', strtotime($start)) . " 00:00:00", date('Y-m-d', strtotime($end)) . " 23:59:59"])
                ->when($user->hasRole('Performance Marketing Admin'), function ($query) {
                    $query->where(function ($query) {
                        $query->where('reservations.source_id', '=', 1)
                            ->orWhere('reservations.source_id', '=', 2);
                    });
                })
                ->when(!empty($selectedSources), function ($query) use ($selectedSources) {
                    $query->whereIn('reservations.source_id', $selectedSources);
                }, function ($query) {
                    $query->whereNotNull('reservations.source_id');
                })
                ->groupBy('reservations.id')
                ->get();
            $sourcesAll = Reservation::select('sources.*', 'reservations.*', DB::raw('source_id, count(source_id) as sourceCount, sum(total_customer) as paxCount'))
                ->leftJoin('sources', 'reservations.source_id', '=', 'sources.id')
                ->whereBetween('reservations.reservation_date', [$start, $end])
                ->when($user->hasRole('Performance Marketing Admin'), function ($query) {
                    $query->where(function ($query) {
                        $query->whereIn('reservations.source_id', [1, 12]);
                    });
                })
                ->when(!empty($selectedSources), function ($query) use ($selectedSources) {
                    $query->whereIn('reservations.source_id', $selectedSources);
                }, function ($query) {
                    $query->whereNotNull('reservations.source_id');
                })
                ->groupBy('source_id')
                ->orderBy('sourceCount', 'DESC')
                ->get();

            $sourcesAllByDate = Reservation::select('sources.*', 'reservations.*', DB::raw('source_id, count(source_id) as sourceCount, sum(total_customer) as paxCount'))
                ->leftJoin('sources', 'reservations.source_id', '=', 'sources.id')
                ->whereBetween('reservations.reservation_date', [$start, $end])
                ->when($user->hasRole('Performance Marketing Admin'), function ($query) {
                    $query->where(function ($query) {
                        $query->where('reservations.source_id', '=', 1)
                            ->orWhere('reservations.source_id', '=', 2);
                    });
                })
                ->when(!empty($selectedSources), function ($query) use ($selectedSources) {
                    $query->whereIn('reservations.source_id', $selectedSources);
                }, function ($query) {
                    $query->whereNotNull('reservations.source_id');
                })
                ->groupBy('reservation_date')
                ->get();

            $reservationByDateCount = Reservation::whereBetween('reservations.reservation_date', [$start, $end])
                ->when($user->hasRole('Performance Marketing Admin'), function ($query) {
                    $query->where(function ($query) {
                        $query->whereIn('reservations.source_id', [1, 12]);
                    });
                })
                ->when(!empty($selectedSources), function ($query) use ($selectedSources) {
                    $query->whereIn('reservations.source_id', $selectedSources);
                }, function ($query) {
                    $query->whereNotNull('reservations.source_id');
                })
                ->count('source_id');

            $paxByDateCount = Reservation::whereBetween('reservations.reservation_date', [$start, $end])
                ->when($user->hasRole('Performance Marketing Admin'), function ($query) {
                    $query->where(function ($query) {
                        $query->whereIn('reservations.source_id', [1, 12]);
                    });
                })
                ->when(!empty($selectedSources), function ($query) use ($selectedSources) {
                    $query->whereIn('reservations.source_id', $selectedSources);
                }, function ($query) {
                    $query->whereNotNull('reservations.source_id');
                })
                ->sum('total_customer');

            //Reservation Source
            $sources = Reservation::select('sources.*', DB::raw('source_id, count(source_id) as sourceCount'))
                ->leftJoin('sources', 'reservations.source_id', '=', 'sources.id')
                ->when($user->hasRole('Performance Marketing Admin'), function ($query) {
                    $query->where(function ($query) {
                        $query->whereIn('reservations.source_id', [1, 12]);
                    });
                })
                ->whereBetween('reservations.reservation_date', [$start, $end])
                ->when(!empty($selectedSources), function ($query) use ($selectedSources) {
                    $query->whereIn('reservations.source_id', $selectedSources);
                }, function ($query) {
                    $query->whereNotNull('reservations.source_id');
                })
                ->groupBy('source_id')
                ->orderBy('sourceCount', 'DESC')
                ->get();
            $sourceLabels = [];
            $sourceData = [];
            $sourceColors = [];

            foreach ($sources as $source) {
                array_push($sourceLabels, $source->source->name);
                array_push($sourceData, $source->sourceCount);
                array_push($sourceColors, $source->source->color);
            }

            //Reservation Source By Date
            $sourcesByDate = Reservation::select('sources.*', 'reservations.*', DB::raw('source_id, count(source_id) as sourceCount'))
                ->leftJoin('sources', 'reservations.source_id', '=', 'sources.id')
                ->whereBetween('reservations.reservation_date', [$start, $end])
                ->when($user->hasRole('Performance Marketing Admin'), function ($query) {
                    $query->where(function ($query) {
                        $query->whereIn('reservations.source_id', [1, 12]);
                    });
                })
                ->when(!empty($selectedSources), function ($query) use ($selectedSources) {
                    $query->whereIn('reservations.source_id', $selectedSources);
                }, function ($query) {
                    $query->whereNotNull('reservations.source_id');
                })
                ->groupBy('reservation_date')
                ->get();
            $sourcesByDateLabels = [];
            $sourcesByDateData = [];
            $sourcesByDateColors = [];
            foreach ($sourcesByDate as $source) {
                array_push($sourcesByDateLabels, $source->reservation_date);
                array_push($sourcesByDateData, $source->sourceCount);
                $sourcesByDateColors[] = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
            }
            //Ciro Report
            $all_payments = ReservationPaymentType::select('payment_types.*', DB::raw('payment_type_id, sum(payment_price) as totalPrice'))
                ->leftJoin('payment_types', 'reservations_payments_types.payment_type_id', '=', 'payment_types.id')
                ->leftJoin('reservations', 'reservations.id', '=', 'payment_types.id')
                ->whereBetween('reservations.reservation_date', [$start, $end])
                ->when($user->hasRole('Performance Marketing Admin'), function ($query) {
                    $query->where(function ($query) {
                        $query->whereIn('reservations.source_id', [1, 12]);
                    });
                })
                ->when(!empty($selectedSources), function ($query) use ($selectedSources) {
                    $query->whereIn('reservations.source_id', $selectedSources);
                }, function ($query) {
                    $query->whereNotNull('reservations.source_id');
                })
                ->groupBy('payment_type_id')
                ->get();
            $payments_customer_count = ReservationPaymentType::leftJoin('reservations', 'reservations_payments_types.reservation_id', '=', 'reservations.id')
                ->whereBetween('reservations.reservation_date', [$start, $end])
                ->when($user->hasRole('Performance Marketing Admin'), function ($query) {
                    $query->where(function ($query) {
                        $query->whereIn('reservations.source_id', [1, 12]);
                    });
                })
                ->when(!empty($selectedSources), function ($query) use ($selectedSources) {
                    $query->whereIn('reservations.source_id', $selectedSources);
                }, function ($query) {
                    $query->whereNotNull('reservations.source_id');
                })
                ->sum('reservations.total_customer');
            $all_paymentLabels = [];
            $all_paymentData = [];
            $all_paymentColors = [];
            foreach ($all_payments as $all_payment) {
                array_push($all_paymentLabels, $all_payment->type_name);
                array_push($all_paymentData, $all_payment->totalPrice);
                $all_paymentColors[] = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
            }

            $cashTl = ReservationPaymentType::where('reservations_payments_types.payment_type_id', '1')
                ->leftJoin('reservations', 'reservations.id', '=', 'reservations_payments_types.reservation_id')
                ->whereBetween('reservations.reservation_date', [date('Y-m-d', strtotime($start)) . " 00:00:00", date('Y-m-d', strtotime($end)) . " 23:59:59"])
                ->when($user->hasRole('Performance Marketing Admin'), function ($query) {
                    $query->where(function ($query) {
                        $query->whereIn('reservations.source_id', [1, 12]);
                    });
                })
                ->when(!empty($selectedSources), function ($query) use ($selectedSources) {
                    $query->whereIn('reservations.source_id', $selectedSources);
                }, function ($query) {
                    $query->whereNotNull('reservations.source_id');
                })
                ->sum("payment_price");

            $cashEur = ReservationPaymentType::where('reservations_payments_types.payment_type_id', '2')
                ->leftJoin('reservations', 'reservations.id', '=', 'reservations_payments_types.reservation_id')
                ->whereBetween('reservations.reservation_date', [date('Y-m-d', strtotime($start)) . " 00:00:00", date('Y-m-d', strtotime($end)) . " 23:59:59"])
                ->when($user->hasRole('Performance Marketing Admin'), function ($query) {
                    $query->where(function ($query) {
                        $query->whereIn('reservations.source_id', [1, 12]);
                    });
                })
                ->when(!empty($selectedSources), function ($query) use ($selectedSources) {
                    $query->whereIn('reservations.source_id', $selectedSources);
                }, function ($query) {
                    $query->whereNotNull('reservations.source_id');
                })
                ->sum("payment_price");

            $cashUsd = ReservationPaymentType::where('reservations_payments_types.payment_type_id', '3')
                ->leftJoin('reservations', 'reservations.id', '=', 'reservations_payments_types.reservation_id')
                ->whereBetween('reservations.reservation_date', [date('Y-m-d', strtotime($start)) . " 00:00:00", date('Y-m-d', strtotime($end)) . " 23:59:59"])
                ->when($user->hasRole('Performance Marketing Admin'), function ($query) {
                    $query->where(function ($query) {
                        $query->whereIn('reservations.source_id', [1, 12]);
                    });
                })
                ->when(!empty($selectedSources), function ($query) use ($selectedSources) {
                    $query->whereIn('reservations.source_id', $selectedSources);
                }, function ($query) {
                    $query->whereNotNull('reservations.source_id');
                })
                ->sum("payment_price");

            $cashPound = ReservationPaymentType::where('reservations_payments_types.payment_type_id', '4')
                ->leftJoin('reservations', 'reservations.id', '=', 'reservations_payments_types.reservation_id')
                ->whereBetween('reservations.reservation_date', [date('Y-m-d', strtotime($start)) . " 00:00:00", date('Y-m-d', strtotime($end)) . " 23:59:59"])
                ->when($user->hasRole('Performance Marketing Admin'), function ($query) {
                    $query->where(function ($query) {
                        $query->whereIn('reservations.source_id', [1, 12]);
                    });
                })
                ->when(!empty($selectedSources), function ($query) use ($selectedSources) {
                    $query->whereIn('reservations.source_id', $selectedSources);
                }, function ($query) {
                    $query->whereNotNull('reservations.source_id');
                })
                ->sum("payment_price");

            $ykbTl = ReservationPaymentType::where('reservations_payments_types.payment_type_id', '5')
                ->leftJoin('reservations', 'reservations.id', '=', 'reservations_payments_types.reservation_id')
                ->whereBetween('reservations.reservation_date', [date('Y-m-d', strtotime($start)) . " 00:00:00", date('Y-m-d', strtotime($end)) . " 23:59:59"])
                ->when($user->hasRole('Performance Marketing Admin'), function ($query) {
                    $query->where(function ($query) {
                        $query->whereIn('reservations.source_id', [1, 12]);
                    });
                })
                ->when(!empty($selectedSources), function ($query) use ($selectedSources) {
                    $query->whereIn('reservations.source_id', $selectedSources);
                }, function ($query) {
                    $query->whereNotNull('reservations.source_id');
                })
                ->sum("payment_price");

            $ziraatTl = ReservationPaymentType::where('reservations_payments_types.payment_type_id', '7')
                ->leftJoin('reservations', 'reservations.id', '=', 'reservations_payments_types.reservation_id')
                ->whereBetween('reservations.reservation_date', [date('Y-m-d', strtotime($start)) . " 00:00:00", date('Y-m-d', strtotime($end)) . " 23:59:59"])
                ->when($user->hasRole('Performance Marketing Admin'), function ($query) {
                    $query->where(function ($query) {
                        $query->whereIn('reservations.source_id', [1, 12]);
                    });
                })
                ->when(!empty($selectedSources), function ($query) use ($selectedSources) {
                    $query->whereIn('reservations.source_id', $selectedSources);
                }, function ($query) {
                    $query->whereNotNull('reservations.source_id');
                })
                ->sum("payment_price");

            $ziraatEuro = ReservationPaymentType::where('reservations_payments_types.payment_type_id', '8')
                ->leftJoin('reservations', 'reservations.id', '=', 'reservations_payments_types.reservation_id')
                ->whereBetween('reservations.reservation_date', [date('Y-m-d', strtotime($start)) . " 00:00:00", date('Y-m-d', strtotime($end)) . " 23:59:59"])
                ->when($user->hasRole('Performance Marketing Admin'), function ($query) {
                    $query->where(function ($query) {
                        $query->whereIn('reservations.source_id', [1, 12]);
                    });
                })
                ->when(!empty($selectedSources), function ($query) use ($selectedSources) {
                    $query->whereIn('reservations.source_id', $selectedSources);
                }, function ($query) {
                    $query->whereNotNull('reservations.source_id');
                })
                ->sum("payment_price");

            $ziraatDolar = ReservationPaymentType::where('reservations_payments_types.payment_type_id', '9')
                ->leftJoin('reservations', 'reservations.id', '=', 'reservations_payments_types.reservation_id')
                ->whereBetween('reservations.reservation_date', [date('Y-m-d', strtotime($start)) . " 00:00:00", date('Y-m-d', strtotime($end)) . " 23:59:59"])
                ->when($user->hasRole('Performance Marketing Admin'), function ($query) {
                    $query->where(function ($query) {
                        $query->whereIn('reservations.source_id', [1, 12]);
                    });
                })
                ->when(!empty($selectedSources), function ($query) use ($selectedSources) {
                    $query->whereIn('reservations.source_id', $selectedSources);
                }, function ($query) {
                    $query->whereNotNull('reservations.source_id');
                })
                ->sum("payment_price");

            $viatorEuro = ReservationPaymentType::where('reservations_payments_types.payment_type_id', '10')
                ->leftJoin('reservations', 'reservations.id', '=', 'reservations_payments_types.reservation_id')
                ->whereBetween('reservations.reservation_date', [date('Y-m-d', strtotime($start)) . " 00:00:00", date('Y-m-d', strtotime($end)) . " 23:59:59"])
                ->when($user->hasRole('Performance Marketing Admin'), function ($query) {
                    $query->where(function ($query) {
                        $query->whereIn('reservations.source_id', [1, 12]);
                    });
                })
                ->when(!empty($selectedSources), function ($query) use ($selectedSources) {
                    $query->whereIn('reservations.source_id', $selectedSources);
                }, function ($query) {
                    $query->whereNotNull('reservations.source_id');
                })
                ->sum("payment_price");

            $all_payments = ReservationPaymentType::select('payment_types.*', DB::raw('payment_type_id, sum(payment_price) as totalPrice'))
                ->leftJoin('payment_types', 'reservations_payments_types.payment_type_id', '=', 'payment_types.id')
                ->leftJoin('reservations', 'reservations.id', '=', 'reservations_payments_types.reservation_id')
                ->when($user->hasRole('Performance Marketing Admin'), function ($query) {
                    $query->where(function ($query) {
                        $query->whereIn('reservations.source_id', [1, 12]);
                    });
                })
                ->whereBetween('reservations.reservation_date', [date('Y-m-d', strtotime($start)) . " 00:00:00", date('Y-m-d', strtotime($end)) . " 23:59:59"])
                ->when(!empty($selectedSources), function ($query) use ($selectedSources) {
                    $query->whereIn('reservations.source_id', $selectedSources);
                }, function ($query) {
                    $query->whereNotNull('reservations.source_id');
                })
                ->groupBy('payment_type_id')
                ->get();

            $open = simplexml_load_file('https://www.tcmb.gov.tr/kurlar/today.xml');

            $euro_satis = $open->Currency[3]->BanknoteSelling;
            $usd_satis = $open->Currency[0]->BanknoteSelling;
            $gbp_satis = $open->Currency[4]->BanknoteSelling;
            $euro_usd_satis = $open->Currency[3]->CrossRateOther;

            $totalUsd = $cashUsd + $ziraatDolar;

            $totalPound = $cashPound;

            //only need pound convert
            $totalEuro = $cashEur + $ziraatEuro + $viatorEuro + $cashUsd * $euro_usd_satis + (($totalPound * $gbp_satis) / $euro_satis) + $ziraatDolar * $euro_usd_satis + $cashTl / $euro_satis + $ykbTl / $euro_satis + $ziraatTl / $euro_satis;

            $totalTl = $cashTl + $ykbTl + $ziraatTl + $cashEur * $euro_satis + $ziraatEuro * $euro_satis + $viatorEuro * $euro_satis + $totalUsd * $usd_satis + $totalPound * $gbp_satis;

            $all_paymentLabels = [];
            $all_paymentData = [];
            $all_paymentColors = [];
            foreach ($all_payments as $all_payment) {
                array_push($all_paymentLabels, $all_payment->type_name);
                array_push($all_paymentData, $all_payment->totalPrice);
                $all_paymentColors[] = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
            }
            // Vehicle reports
            //Reservation Source By Date
            $vehiclesByDate = Reservation::select('vehicles.*', 'reservations.*', DB::raw('vehicle_id, sum(total_customer) as vehicleCount'))
                ->leftJoin('vehicles', 'reservations.vehicle_id', '=', 'vehicles.id')
                ->with('brand')
                ->whereBetween('reservations.reservation_date', [$start, $end])
                ->when($user->hasRole('Performance Marketing Admin'), function ($query) {
                    $query->where(function ($query) {
                        $query->whereIn('reservations.source_id', [1]);
                    });
                })
                ->when(!empty($selectedSources), function ($query) use ($selectedSources) {
                    $query->whereIn('reservations.source_id', $selectedSources);
                }, function ($query) {
                    $query->whereNotNull('reservations.source_id');
                })
                ->groupBy('vehicle_id')
                ->get();
            $vehiclesLabels = [];
            $vehiclesData = [];
            $vehiclesColors = [];
            foreach ($vehiclesByDate as $vehicle) {
                array_push($vehiclesLabels, $vehicle->model);
                array_push($vehiclesData, $vehicle->vehicleCount);
                $vehiclesColors[] = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
            }

            $data = array(
                'payments_customer_count'  => $payments_customer_count,
                'reservationByDateCount'   => $reservationByDateCount,
                'paxByDateCount'           => $paxByDateCount,
                'vehiclesByDate'           => $vehiclesByDate,
                'vehiclesLabels'           => $vehiclesLabels,
                'vehiclesData'             => $vehiclesData,
                'vehiclesColors'           => $vehiclesColors,
                'sourcesByDateLabels'      => $sourcesByDateLabels,
                'sourcesByDateData'        => $sourcesByDateData,
                'sourcesByDateColors'      => $sourcesByDateColors,
                'sourcesAllByDate'         => $sourcesAllByDate,
                'all_paymentLabels'        => $all_paymentLabels,
                'all_paymentData'          => $all_paymentData,
                'all_paymentColors'        => $all_paymentColors,
                'sourceLabels'             => $sourceLabels,
                'sourceData'               => $sourceData,
                'sourceColors'             => $sourceColors,
                'reservationsAll'          => $reservationsAll,
                'sourcesAll'               => $sourcesAll,
                'cashTl'                   => $cashTl,
                'cashEur'                  => $cashEur,
                'cashUsd'                  => $cashUsd,
                'cashPound'                => $cashPound,
                'ykbTl'                    => $ykbTl,
                'ziraatTl'                 => $ziraatTl,
                'ziraatEuro'               => $ziraatEuro,
                'ziraatDolar'              => $ziraatDolar,
                'viatorEuro'               => $viatorEuro,
                'totalEuro'                => $totalEuro,
                'totalTl'                  => $totalTl,
                'start'                    => $start,
                'end'                      => $end,
                'sourcesSelect'            => $sourcesSelect,
                'selectedSources'          => $selectedSources

            );

            if ($user->hasRole('Performance Marketing Admin')) {
                return view('admin.reports.reservation_report_pm')->with($data);
            } else {
                return view('admin.reports.reservation_report')->with($data);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function sourceReport(Request $request)
    {
        $data = Source::select("sources.*", \DB::raw("(SELECT count(*) FROM reservations a WHERE a.source_id = sources.id) as aCount"))->get();

        return json_encode($data);
    }

    public function vehicleReport(Request $request)
    {
        $data = Vehicle::select("vehicles.*", \DB::raw("(SELECT count(*) FROM reservations a WHERE a.vehicle_id = vehicles.id) as aCount"))->get();

        return json_encode($data);
    }
}
