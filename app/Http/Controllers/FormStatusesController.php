<?php

namespace App\Http\Controllers;

use App\Models\FormStatuses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormStatusesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        try {
            $form_statuses = FormStatuses::orderBy('name', 'asc')->get();
            $data = array('form_statuses' => $form_statuses);
            return view('admin.formstatuses.form_statuses')->with($data);   
        }
        catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store(Request $request)
    {
        try {
            $newData = new FormStatuses();
            $newData->name = $request->input('statusName');
            $newData->color = $request->input('statusColor');
            $newData->user_id = auth()->user()->id;

            $result = $newData->save();

            if ($result){
                return redirect('/definitions/formstatuses')->with('message', 'Form Durumu Başarıyla Eklendi!');
            }
            else {
                return response(false, 500);
            }
        }
        catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getDiscount($id)
    {
        try {
            $discounts = Discount::where('id', '=', $id)->first();

            return response()->json([$discounts], 200);
        }
        catch (\Throwable $th) {
            throw $th;
        }
       
    }

    public function edit($id)
    {
        try {
            $form_status = FormStatuses::where('id','=', $id)->first();
            return view('admin.formstatuses.edit_form_statuses', ['form_status' => $form_status]);
        }
        catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $user = auth()->user();

            $temp['name'] = $request->input('statusName');
            $temp['color'] = $request->input('statusColor');

            if (FormStatuses::where('id', '=', $id)->update($temp)) {
                return redirect('/definitions/formstatuses')->with('message', 'Form Durumu Başarıyla Güncellendi!');
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
        try {
            FormStatuses::where('id', '=', $id)->delete();
            return redirect('definitions/formstatuses')->with('message', 'Form Durumu Başarıyla Silindi!');
        }
        catch (\Throwable $th) {
            throw $th;
        }
    }
}
