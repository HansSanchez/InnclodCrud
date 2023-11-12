<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tip_tipos')->insert([
            ['TIP_ID' => 1, 'TIP_NOMBRE' => 'Instructivo',  'TIP_PREFIJO' => 'INS',  'created_at' => now(), 'updated_at' => now(), 'deleted_at' => null],
            ['TIP_ID' => 2, 'TIP_NOMBRE' => 'Reporte',      'TIP_PREFIJO' => 'REP',  'created_at' => now(), 'updated_at' => now(), 'deleted_at' => null],
            ['TIP_ID' => 3, 'TIP_NOMBRE' => 'Análisis',     'TIP_PREFIJO' => 'ANA',  'created_at' => now(), 'updated_at' => now(), 'deleted_at' => null],
            ['TIP_ID' => 4, 'TIP_NOMBRE' => 'Resumen',      'TIP_PREFIJO' => 'RES',  'created_at' => now(), 'updated_at' => now(), 'deleted_at' => null],
            ['TIP_ID' => 5, 'TIP_NOMBRE' => 'Presentación', 'TIP_PREFIJO' => 'PRES', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => null]
        ]);
    }
}
