<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarbeiroFilialComissao extends Model
{
    use HasFactory;
    protected $table = 'barbeiro_filial_comissoes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'barbeiro_id',
        'filial_id',
        'tipo_comissao',
        'valor_comissao',
        'ativo'
    ];

    protected $casts = [
        'valor_comissao' => 'decimal:2',
        'ativo' => 'boolean'
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
