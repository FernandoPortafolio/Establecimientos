@extends('layouts.app')

@section('styles')
    {{-- Leaflet --}}
    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
        integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
        crossorigin=""
    />
    <link
        rel="stylesheet"
        href="https://unpkg.com/esri-leaflet-geocoder/dist/esri-leaflet-geocoder.css"
    />

    {{-- Dropzone --}}
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/dropzone.min.css"
        integrity="sha512-jU/7UFiaW5UBGODEopEqnbIAHOI8fO6T99m7Tsmqs2gkdujByJfkCbbfPSN4Wlqlb9TGnsuC0YgUgWkRBK7B9A=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    />
@endsection

@section('content')
    <div class="container">
        <h1 class="text-center mt-4">Editar Establecimiento</h1>

        <div class="mt-5 row justify-content-center">
            <form
                action="{{ route('establecimiento.update', ['establecimiento' => $establecimiento->id]) }}"
                method="POST"
                class="col-12 col-md-9 card card-body"
                enctype="multipart/form-data"
            >
                @csrf
                @method('PUT')
                <fieldset class="border p-4">
                    <legend class="text-primary">Nombre, Categoría e Imagen Principal</legend>

                    <div class="form-group">
                        <label for="nombre">Nombre establecimiento</label>
                        <input
                            type="text"
                            name="nombre"
                            id="nombre"
                            placeholder="Nombre de tu establecimiento"
                            class="form-control @error('nombre') is-invalid @enderror"
                            value="{{ $establecimiento->nombre }}"
                        >

                        @error('nombre')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="categoria">Categoría</label>
                        <select
                            name="categoria_id"
                            id="categoria"
                            class="form-control @error('categoria_id') is-invalid @enderror"
                        >
                            <option
                                selected
                                disabled
                            >--Seleccione--</option>

                            @foreach ($categorias as $categoria)
                                <option
                                    value="{{ $categoria->id }}"
                                    {{ $establecimiento->categoria_id == $categoria->id ? 'selected' : '' }}
                                >{{ $categoria->nombre }}</option>
                            @endforeach

                        </select>

                        @error('categoria_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nombre">Imagen Principal</label>
                        <input
                            type="file"
                            name="imagen_principal"
                            id="imagen_principal"
                            class="form-control-file @error('imagen_principal') is-invalid @enderror"
                        >

                        <img
                            src="/storage/{{ $establecimiento->imagen_principal }}"
                            alt="Imagen del establecimiento"
                            style="width: 200px; margin-top:20px"
                        >
                    </div>
                </fieldset>

                <fieldset class="border p-4 mt-5">
                    <legend class="text-primary">Ubicación</legend>

                    <div class="form-group">
                        <label for="nombre">Coloca la dirección del Establecimiento</label>
                        <input
                            type="text"
                            id="formBuscador"
                            placeholder="Calle del Negocio"
                            class="form-control"
                        >
                        <p class="text-secondary mt-2 mb-3 text-center">El asistente colocará una dirección estimada, mueve
                            el pin hacia el lugar correcto</p>

                    </div>

                    <div class="form-group">
                        <div
                            id="mapa"
                            style="height: 400px"
                        ></div>
                    </div>

                    <p>Confirma que los siguientes campos son correctos</p>

                    <div class="form-group">
                        <label for="direccion">Dirección</label>
                        <input
                            type="text"
                            name="direccion"
                            id="direccion"
                            class="form-control @error('direccion') is-invalid @enderror"
                            placeholder="Direccion..."
                            value="{{ $establecimiento->direccion }}"
                        >
                        @error('direccion')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="colonia">Colonia</label>
                        <input
                            type="text"
                            name="colonia"
                            id="colonia"
                            class="form-control @error('colonia') is-invalid @enderror"
                            placeholder="Colonia..."
                            value="{{ $establecimiento->colonia }}"
                        >
                        @error('colonia')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <input
                        type="hidden"
                        name="lat"
                        id="lat"
                        value="{{ $establecimiento->lat }}"
                    >
                    <input
                        type="hidden"
                        name="lng"
                        id="lng"
                        value="{{ $establecimiento->lng }}"
                    >
                </fieldset>

                <fieldset class="border p-4 mt-5">
                    <legend class="text-primary">Información Establecimiento: </legend>
                    <div class="form-group">
                        <label for="nombre">Teléfono</label>
                        <input
                            type="tel"
                            class="form-control @error('telefono')  is-invalid  @enderror"
                            id="telefono"
                            placeholder="Teléfono Establecimiento"
                            name="telefono"
                            value="{{ $establecimiento->telefono }}"
                        >

                        @error('telefono')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nombre">Descripción</label>
                        <textarea
                            class="form-control  @error('descripcion')  is-invalid  @enderror"
                            name="descripcion"
                        >{{ $establecimiento->descripcion }}</textarea>

                        @error('descripcion')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nombre">Hora Apertura:</label>
                        <input
                            type="time"
                            class="form-control @error('apertura')  is-invalid  @enderror"
                            id="apertura"
                            name="apertura"
                            value="{{ $establecimiento->apertura }}"
                        >
                        @error('apertura')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nombre">Hora Cierre:</label>
                        <input
                            type="time"
                            class="form-control @error('cierre')  is-invalid  @enderror"
                            id="cierre"
                            name="cierre"
                            value="{{ $establecimiento->cierre }}"
                        >
                        @error('cierre')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </fieldset>

                <fieldset class="border p-4 mt-5">
                    <legend class="text-primary">Imágenes Establecimiento: </legend>
                    <div class="form-group">
                        <label for="dropzone">Imagenes</label>
                        <div
                            id="dropzone"
                            class="dropzone form-control"
                        ></div>
                    </div>

                    @if (count($imagenes) > 0)
                        @foreach ($imagenes as $imagen)
                            <input
                                type="hidden"
                                class="galeria"
                                value="{{ $imagen->ruta_imagen }}"
                            >
                            <input
                                type="hidden"
                                class="galeria-ids"
                                value="{{ $imagen->id }}"
                            >
                        @endforeach
                    @endif
                </fieldset>

                <input
                    type="hidden"
                    id="uuid"
                    name="uuid"
                    value="{{ $establecimiento->uuid }}"
                >

                <input
                    type="submit"
                    class="btn btn-primary mt-3 block"
                    value="Registrar Establecimiento"
                >


            </form>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- Leaflet --}}
    <script
        src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
        integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
        crossorigin=""
        defer
    ></script>

    <!-- Esri Leaflet -->
    <script
        src="https://unpkg.com/esri-leaflet"
        defer
    ></script>

    <!-- Esri Leaflet Geocoder -->
    <script
        src="https://unpkg.com/esri-leaflet-geocoder"
        defer
    ></script>

    {{-- Dropzone --}}
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js"
        integrity="sha512-VQQXLthlZQO00P+uEu4mJ4G4OAgqTtKG1hri56kQY1DtdLeIqhKUp9W/lllDDu3uN3SnUNawpW7lBda8+dSi7w=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
        defer
    ></script>
@endsection
