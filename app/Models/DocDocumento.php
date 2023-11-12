<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class DocDocumento extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'DOC_ID';

    protected $fillable = [
        "DOC_ID",
        "DOC_NOMBRE",
        "DOC_CODIGO",
        "DOC_CONTENIDO",
        "DOC_ID_TIPO",
        "DOC_ID_PROCESO"
    ];

    protected $appends = [
        'CreatedLabel'
    ];

    public function scopeSearch($query, $search_term)
    {
        $query->where('DOC_ID', $search_term)
            ->orWhere('DOC_NOMBRE', 'LIKE', '%' . $search_term . '%')
            ->orWhere('DOC_CODIGO', 'LIKE', '%' . $search_term . '%')
            ->orWhere('DOC_CONTENIDO', 'LIKE', '%' . $search_term . '%')
            ->orWhere(function ($query) use ($search_term) {
                $query->whereHas('process', function ($query2) use ($search_term) {
                    $query2->where('PRO_ID', 'LIKE', '%' . $search_term . '%')
                        ->orWhere('PRO_NOMBRE', 'LIKE', '%' . $search_term . '%');
                });
            })
            ->orWhere(function ($query) use ($search_term) {
                $query->whereHas('type', function ($query2) use ($search_term) {
                    $query2->where('TIP_ID', 'LIKE', '%' . $search_term . '%')
                        ->orWhere('TIP_NOMBRE', 'LIKE', '%' . $search_term . '%');
                });
            });
    }

    public function scopeWithRelations($query)
    {
        return $query->with([
            // RELACIÓN CON EL PROCESO
            'process' => function ($query) {
                $query->select(
                    'pro_procesos.PRO_ID',
                    'pro_procesos.PRO_NOMBRE',
                    'pro_procesos.PRO_PREFIJO',
                );
            },
            // RELACIÓN CON EL TIPO
            'type' => function ($query) {
                $query->select(
                    'tip_tipos.TIP_ID',
                    'tip_tipos.TIP_NOMBRE',
                    'tip_tipos.TIP_PREFIJO',
                );
            },
        ]);
    }

    public function scopeFilter($query, $request)
    {
        return $query->where(function ($query) use ($request, ) {
            // FILTRO PARA BÚSQUEDA DE TEXTO EN OBSERVACIONES
            if ($request->search)
                $query->search($request->search);

            // FILTRO PARA OBTENER LOS DOCUMENTOS POR PROCESO
            if ($request->process_model) {
                $process = json_decode($request->process_model);
                $query->whereHas('process', function ($query2) use ($process) {
                    $query2->where('PRO_ID', $process->code);
                });
            }
            // FILTRO PARA OBTENER LOS DOCUMENTOS POR TIPO
            if ($request->type_model) {
                $type = json_decode($request->type_model);
                $query->whereHas('type', function ($query2) use ($type) {
                    $query2->where('TIP_ID', $type->code);
                });
            }
        });
    }

    public function process()
    {
        return $this->belongsTo(ProProceso::class, 'DOC_ID_PROCESO');
    }

    public function type()
    {
        return $this->belongsTo(TipTipo::class, 'DOC_ID_TIPO');
    }

    public function getCreatedLabelAttribute()
    {
        try {
            if ($this->created_at != null) {
                if (gettype($this->created_at) == "string") {
                    return date('Y-m-d', strtotime($this->created_at));
                };
                return $this->created_at->format('Y-m-d H:i');
            }
        } catch (\Exception $exception) {
            Log::error("(DocDocumentoModel - getCreatedLabelAttribute) ERROR => " . $exception->getMessage());
        }
        return null;
    }
}
