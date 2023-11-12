<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProcessTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pro_procesos')->insert([
            ['PRO_ID' => 1, 'PRO_NOMBRE' => 'Ingeniería',       'PRO_PREFIJO' => 'ING', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => null],
            ['PRO_ID' => 2, 'PRO_NOMBRE' => 'Marketing',        'PRO_PREFIJO' => 'MKT', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => null],
            ['PRO_ID' => 3, 'PRO_NOMBRE' => 'Ventas',           'PRO_PREFIJO' => 'VEN', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => null],
            ['PRO_ID' => 4, 'PRO_NOMBRE' => 'Recursos Humanos', 'PRO_PREFIJO' => 'RH',   'created_at' => now(), 'updated_at' => now(), 'deleted_at' => null],
            ['PRO_ID' => 5, 'PRO_NOMBRE' => 'Operaciones',      'PRO_PREFIJO' => 'OP',   'created_at' => now(), 'updated_at' => now(), 'deleted_at' => null]
        ]);
    }
}
