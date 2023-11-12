<?php

namespace App\Http\Controllers;

use App\Models\TipTipo;
use Illuminate\Http\Request;

class TipTipoController extends Controller
{
    public function getTypes(Request $request)
    {
        return TipTipo::select('TIP_ID AS code', 'TIP_NOMBRE AS label')
            ->search($request->search)
            ->orderBy('TIP_ID', 'ASC')
            ->simplePaginate(25);
    }

    public function getTypesFilter(Request $request)
    {
        return TipTipo::select('TIP_ID AS code', 'TIP_NOMBRE AS label')
            ->search($request->search)
            ->orderBy('TIP_ID', 'ASC')
            ->simplePaginate(25);
    }

    public function getTypePrefix(Request $request)
    {
        return TipTipo::select('TIP_ID', 'TIP_PREFIJO')
            ->where(function ($query) use ($request) {
                if ($request->has('type_id')) {
                    $object = json_decode($request->type_id);
                    $query->where('TIP_ID', $object->code);
                }
            })
            ->pluck('TIP_PREFIJO');
    }
}
