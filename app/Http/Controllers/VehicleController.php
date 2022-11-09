<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Brand;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VehicleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        try {
            $vehicles = Vehicle::all();
            $brands = Brand::all();
            $data = array('vehicles' => $vehicles, 'brands' => $brands);
            return view('admin.vehicles.vehicles_list')->with($data);
        }
        catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store(Request $request)
    {
        try {
            $newData = new Vehicle();
            $newData->number_plate = $request->input('plate');
            $newData->brand_id = $request->input('brandId');
            $newData->model = $request->input('model');
            $newData->seat = $request->input('seat');
            $newData->suitcase = $request->input('suitcase');
            $newData->user_id = auth()->user()->id;
            $result = $newData->save();

            if ($result) {
                return redirect()->route('vehicle.index')->with('message', 'Araç Başarıyla Eklendi!');
            }
            else {
                return response(false, 500);
            }
        }
        catch (\Throwable $th) {
            throw $th;
        }
    }

    public function edit($id)
    {
        $vehicle = Vehicle::where('id','=',$id)->first();
        $brands = Brand::all();

        return view('admin.vehicles.edit_vehicle', ['vehicle' => $vehicle, 'brands' => $brands]);
    }

    public function update(Request $request, $id)
    {
        try {
            $user = auth()->user();

            $temp['number_plate'] = $request->input('plate');
            $temp['brand_id'] = $request->input('brandId');
            $temp['model'] = $request->input('model');
            $temp['seat'] = $request->input('seat');
            $temp['suitcase'] = $request->input('suitcase');

            if (Vehicle::where('id', '=', $id)->update($temp)) {
                return redirect()->route('vehicle.index')->with('message', 'Araç Başarıyla Güncellendi!');
            }
            else {
                return back()->withInput($request->input());
            }
        }
        catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy($id){
        Vehicle::where('id', '=', $id)->delete();
        return redirect()->route('vehicle.index')->with('message', 'Araç Başarıyla Silindi!');
    }
}
