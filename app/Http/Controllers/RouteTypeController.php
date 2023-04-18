<?php

namespace App\Http\Controllers;

use App\Models\RouteType;
use Illuminate\Http\Request;

class RouteTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        try {
            $route_types = RouteType::orderBy('name', 'asc')->get();
            $data = array('route_types' => $route_types);
            return view('admin.routetypes.route_types')->with($data);
        }
        catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store(Request $request)
    {
        try {
            $newData = new RouteType();
            $newData->name = $request->input('name');
            $newData->color = $request->input('color');
            $newData->user_id = auth()->user()->id;

            $result = $newData->save();

            if ($result){
                return redirect()->route('routetype.index')->with('message', 'Rota Türü Başarıyla Eklendi!');
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
        $route_type = RouteType::where('id','=', $id)->first();
        return view('admin.routetypes.edit_route_types', ['route_type' => $route_type]);
    }

    public function update(Request $request, $id)
    {
        try {
            $user = auth()->user();

            $temp['name'] = $request->input('name');
            $temp['color'] = $request->input('color');

            if (RouteType::where('id', '=', $id)->update($temp)) {
                return redirect()->route('routetype.index')->with('message', 'Rota Türü Başarıyla Güncellendi!');
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
        RouteType::where('id', '=', $id)->delete();
        return redirect()->route('routetype.index')->with('message', 'Rota Türü Başarıyla Silindi!');
    }
}
