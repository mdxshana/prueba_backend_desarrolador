<?php

use Illuminate\Database\Seeder;

class TipoDocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\TipoDocumento::query()->insert([
            [
                'sigla' => 'CC',
                'descripcion' => 'Cédula de ciudadania'
            ],
            [
                'sigla' => 'NIT',
                'descripcion' => 'NIT'
            ],
            [
                'sigla' => 'CE',
                'descripcion' => 'Cédula de extrajería'
            ]
        ]);
    }
}
