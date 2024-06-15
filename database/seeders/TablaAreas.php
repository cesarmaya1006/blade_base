<?php

namespace Database\Seeders;

use App\Models\Empresa\EmpGrupo;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TablaAreas extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('areas')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

        $datas = [
            [
                'area_id' => null,
                'empresa_id' => 1,
                'area' => 'Gerencia',
            ],
            [
                'area_id' => 1,
                'empresa_id' => 1,
                'area' => 'Dirección Administrativa',
            ],
            [
                'area_id' => 1,
                'empresa_id' => 1,
                'area' => 'Dirección Técnica',
            ],
            [
                'area_id' => 1,
                'empresa_id' => 1,
                'area' => 'Dirección Operativa',
            ],
        ];

        $grupos = EmpGrupo::get();

        foreach ($grupos as $grupo) {
            foreach ($grupo->empresas as $empresa) {
                foreach ($datas as $data) {
                    DB::table('areas')->insert([
                        'area_id' => $data['area_id'],
                        'empresa_id' => $empresa->id,
                        'area' => $data['area'],
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ]);
                }
            }
        }

    }
}
