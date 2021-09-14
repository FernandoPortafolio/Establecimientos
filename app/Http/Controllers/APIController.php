<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Establecimiento;
use App\Models\Image;
use Illuminate\Http\Request;

class APIController extends Controller
{
    // Obtener todas las categorias
    public function categorias()
    {
        $categorias = Categoria::all();
        return response()->json($categorias);
    }

    public function categoria(Categoria $categoria)
    {
        $categoria = Categoria::where('id', $categoria->id)->with(
            [
                'establecimientos' => function ($query) {
                    $query->take(3);
                }
            ]
        )->first();

        return response()->json($categoria);
    }

    public function allCategoria(Categoria $categoria)
    {
        $categoria = Categoria::where('id', $categoria->id)->with(['establecimientos', 'establecimientos.categoria'])->first();

        return response()->json($categoria);
    }

    public function establecimiento(Establecimiento $establecimiento)
    {
        $imagenes = Image::where('id_establecimiento', $establecimiento->uuid)->get();
        $establecimiento->imagenes = $imagenes;
        return $establecimiento;
    }

    public function establecimientos()
    {
        $establecimientos = Establecimiento::with('categoria')->get();
        return response()->json($establecimientos);
    }
}
