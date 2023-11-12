<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipTipo extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'TIP_ID';

    protected $fillable = ['TIP_NOMBRE', 'TIP_PREFIJO'];

    public function scopeSearch($query, $search_term)
    {
        $query->where('TIP_ID', $search_term)
            ->orWhere('TIP_NOMBRE', 'LIKE', '%' . $search_term . '%');
    }
}
