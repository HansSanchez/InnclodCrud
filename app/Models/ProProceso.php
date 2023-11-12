<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProProceso extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'PRO_ID';

    protected $fillable = ['PRO_NOMBRE', 'PRO_PREFIJO'];

    public function scopeSearch($query, $search_term)
    {
        $query->where('PRO_ID', $search_term)
            ->orWhere('PRO_NOMBRE', 'LIKE', '%' . $search_term . '%');
    }

}
