<?php

namespace App\Http\Controllers;

use App\Models\ProProceso;
use Illuminate\Http\Request;

class ProProcesoController extends Controller
{

    public function getProcesses(Request $request)
    {
        return ProProceso::select('PRO_ID AS code', 'PRO_NOMBRE AS label')
            ->search($request->search)
            ->orderBy('PRO_ID', 'ASC')
            ->simplePaginate(25);
    }

    public function getProcessesFilter(Request $request)
    {
        return ProProceso::select('PRO_ID AS code', 'PRO_NOMBRE AS label')
            ->search($request->search)
            ->orderBy('PRO_ID', 'ASC')
            ->simplePaginate(25);
    }

    public function getProcessPrefix(Request $request)
    {
        return ProProceso::select('PRO_ID', 'PRO_PREFIJO')
            ->where(function ($query) use ($request) {
                if ($request->has('pro_id')) {
                    $object = json_decode($request->pro_id);
                    $query->where('PRO_ID', $object->code);
                }
            })
            ->pluck('PRO_PREFIJO');
    }
}
