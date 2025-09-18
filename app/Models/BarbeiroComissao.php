<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarbeiroComissao extends Model
{
    use HasFactory;
    protected $table = 'barbeiro_comissoes';
    protected $fillable = [
        'barbeiro_id',
        'filial_id',
        'tipo_comissao_filial',
        'valor_comissao_filial'
    ];

    protected $casts = [
        'valor_comissao_filial' => 'decimal:2'
    ];

    public function barbeiro()
    {
        return $this->belongsTo(Barbeiro::class);
    }

    public function filial()
    {
        return $this->belongsTo(Filial::class);
    }
}
