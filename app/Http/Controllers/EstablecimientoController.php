<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use App\Models\Establecimiento;
use App\Models\Image as MyImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class EstablecimientoController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorias = Categoria::all();
        return view('establecimientos.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required',
            'categoria_id' => 'required|numeric|exists:categorias,id',
            'imagen_principal' => 'required|image|max:1024',
            'direccion' => 'required',
            'colonia' => 'required',
            'lat' => 'required',
            'lng' => 'required',
            'telefono' => 'required',
            'descripcion' => 'required|min:50',
            'apertura' => 'date_format:H:i',
            'cierre' => 'date_format:H:i|after:apertura',
            'uuid' => 'required|uuid'
        ]);

        //Guardar la imagen
        $ruta_imagen = $request->file('imagen_principal')->store('principales', 'public');

        //Resize a la imagen
        $img = Image::make(public_path('storage/' . $ruta_imagen))->fit(800, 600);
        $img->save();

        $establecimiento = new Establecimiento($data);
        $establecimiento->imagen_principal = $ruta_imagen;
        $establecimiento->user_id = Auth::user()->id;
        $establecimiento->save();

        return back()->with('estado', 'Tu información se almacenó correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Establecimiento  $establecimiento
     * @return \Illuminate\Http\Response
     */
    public function show(Establecimiento $establecimiento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Establecimiento  $establecimiento
     * @return \Illuminate\Http\Response
     */
    public function edit(Establecimiento $establecimiento)
    {
        $categorias = Categoria::all();
        $establecimiento = Auth::user()->establecimiento;
        //corregir formato de fecha para firefox
        $establecimiento->cierre = date('H:i', strtotime($establecimiento->cierre));
        $establecimiento->apertura = date('H:i', strtotime($establecimiento->apertura));

        $imagenes = MyImage::where('id_establecimiento', $establecimiento->uuid)->get();
        return view('establecimientos.edit', compact('categorias', 'establecimiento', 'imagenes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Establecimiento  $establecimiento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Establecimiento $establecimiento)
    {
        $this->authorize('update', $establecimiento);
        $data = $request->validate([
            'nombre' => 'required',
            'categoria_id' => 'required|numeric|exists:categorias,id',
            'imagen_principal' => 'image|max:1024',
            'direccion' => 'required',
            'colonia' => 'required',
            'lat' => 'required',
            'lng' => 'required',
            'telefono' => 'required',
            'descripcion' => 'required|min:50',
            'apertura' => 'date_format:H:i',
            'cierre' => 'date_format:H:i|after:apertura',
            'uuid' => 'required|uuid'
        ]);
        $establecimiento->nombre = $data['nombre'];
        $establecimiento->categoria_id = $data['categoria_id'];
        $establecimiento->direccion = $data['direccion'];
        $establecimiento->colonia = $data['colonia'];
        $establecimiento->lat = $data['lat'];
        $establecimiento->lng = $data['lng'];
        $establecimiento->telefono = $data['telefono'];
        $establecimiento->descripcion = $data['descripcion'];
        $establecimiento->apertura = $data['apertura'];
        $establecimiento->cierre = $data['cierre'];
        $establecimiento->uuid = $data['uuid'];

        if ($request->file('imagen_principal')) {

            //Eliminar la imagen anterior
            Storage::disk('public')->delete($establecimiento->imagen_principal);

            //Guardar la imagen nueva
            $ruta_imagen = $request->file('imagen_principal')->store('principales', 'public');

            //Resize a la imagen
            $img = Image::make(public_path('storage/' . $ruta_imagen))->fit(800, 600);
            $img->save();

            $establecimiento->imagen_principal = $ruta_imagen;
        }

        $establecimiento->save();
        return back()->with('estado', 'Tu información se almacenó correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Establecimiento  $establecimiento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Establecimiento $establecimiento)
    {
        //
    }
}
