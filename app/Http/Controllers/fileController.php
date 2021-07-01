<?php

namespace App\Http\Controllers;

use App\Imports\SellerImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class fileController extends Controller
{
    public function load(Request $request)
    {
        $file = null;
        if ($request->file('statistics')) {
            $file = $request->file('statistics')->storeAs('', 'Cotizaciones.xlsx');
            return back()->with('success', 'Archivo cargado con éxito');
        }

        return back()->with('error', 'No se ha cargado el archivo correctamente, intente de nuevo por favor');
    }

    public function download(Request $request)
    {
        $test = null;
        $data = Excel::toArray(new SellerImport,  Storage::path('Cotizaciones.xlsx'));
        return $data;
    }


    public function show(Request $request)
    {
        $data = null;
        return back()->with('success', 'Archivo cargado con éxito');
    }
}
