<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        try {
            $brands = Brand::orderBy('name', 'asc')->get();
            $data = array('brands' => $brands);
            return view('admin.brands.brands_list')->with($data);   
        }
        catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store(Request $request)
    {
        try {
            $newData = new Brand();
            $newData->name = $request->input('name');
            $newData->user_id = auth()->user()->id;
            $result = $newData->save();

            if ($result){
                return redirect()->route('brand.index')->with('message', 'Marka Başarıyla Kaydedildi!');
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
        $brand = Brand::where('id','=', $id)->first();
        return view('admin.brands.edit_brand', ['brand' => $brand]);
    }

    public function update(Request $request, $id)
    {
        try {
            $user = auth()->user();

            $temp['name'] = $request->input('name');

            if (Brand::where('id', '=', $id)->update($temp)) {
                return redirect()->route('brand.index')->with('message', 'Marka Başarıyla Güncellendi!');
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
        Brand::where('id', '=', $id)->delete();
        return redirect()->route('brand.index')->with('message', 'İndirim Başarıyla Silindi!');
    }
}
