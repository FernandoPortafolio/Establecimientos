<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categorias')->insert([
            'nombre' => 'Restaurant',
            'slug'   => Str::slug('Restaurant'),
        ]);

        DB::table('categorias')->insert([
            'nombre' => 'Café',
            'slug'   => Str::slug('Café'),
        ]);

        DB::table('categorias')->insert([
            'nombre' => 'Hoteles',
            'slug'   => Str::slug('Hoteles'),
        ]);

        DB::table('categorias')->insert([
            'nombre' => 'Bar',
            'slug'   => Str::slug('Bar'),
        ]);

        DB::table('categorias')->insert([
            'nombre' => 'Hospitales',
            'slug'   => Str::slug('Hospitales'),
        ]);

        DB::table('categorias')->insert([
            'nombre' => 'Gimnasio',
            'slug'   => Str::slug('Gimnasio'),
        ]);

        DB::table('categorias')->insert([
            'nombre' => 'Doctor',
            'slug'   => Str::slug('Doctor'),
        ]);
    }
}
