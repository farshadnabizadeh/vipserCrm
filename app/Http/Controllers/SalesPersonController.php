<?php

namespace App\Http\Controllers;

use App\Models\SalesPerson;
use Illuminate\Http\Request;

class SalesPersonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        try {
            $sales_persons = SalesPerson::orderBy('name', 'asc')->get();
            $data = array('sales_persons' => $sales_persons);
            return view('admin.salespersons.index')->with($data);
        }
        catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store(Request $request)
    {
        try {
            $newData = new SalesPerson();
            $newData->name = $request->input('name');
            $newData->note = $request->input('note');
            $newData->user_id = auth()->user()->id;

            $result = $newData->save();

            if ($result){
                return redirect()->route('salesperson.index')->with('message', 'Satışçı Başarıyla Eklendi!');
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
        $sales_person = SalesPerson::where('id','=', $id)->first();
        return view('admin.salespersons.edit', ['sales_person' => $sales_person]);
    }

    public function update(Request $request, $id)
    {
        try {
            $user = auth()->user();

            $temp['name'] = $request->input('name');
            $temp['note'] = $request->input('note');

            if (SalesPerson::where('id', '=', $id)->update($temp)) {
                return redirect()->route('salesperson.index')->with('message', 'Satışçı Başarıyla Güncellendi!');
            }
            else {
                return back()->withInput($request->input());
            }
        }
        catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy($id)
    {
        SalesPerson::where('id', '=', $id)->delete();
        return redirect()->route('salesperson.index')->with('message', 'Satışçı Başarıyla Silindi!');
    }
}
