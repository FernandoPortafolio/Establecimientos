<?php

namespace App\Http\Controllers;

use App\Models\Establecimiento;
use Illuminate\Http\Request;
use App\Models\Image as MyImage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageController extends Controller
{
    function store(Request $request)
    {
        $ruta_imagen = $request->file('image')->store('establecimientos', 'public');

        //resize a la imagen
        $imagen = Image::make(public_path("storage/$ruta_imagen"))->fit(800, 450);
        $imagen->save();

        //almacenar con modelo
        $imagenDB = new MyImage();
        $imagenDB->id_establecimiento = $request['uuid'];
        $imagenDB->ruta_imagen = $ruta_imagen;
        $imagenDB->save();

        $respuesta = [
            'path' => $ruta_imagen,
            'image_id' => $imagenDB->id
        ];

        return response()->json($respuesta);
    }

    function destroy(MyImage $image)
    {
        //seguridad
        $establecimiento = Establecimiento::where('uuid', $image->id_establecimiento)->first();
        $this->authorize('delete', $establecimiento);

        $image->delete();
        if (File::exists('storage/' . $image->ruta_imagen))
            Storage::disk('public')->delete($image->ruta_imagen);

        return response()->json(['message' => 'Image deleted', 'image' => $image]);
    }
}
