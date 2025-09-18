<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarbeiroServicoComissao extends Model
{
    use HasFactory;
    protected $table = 'barbeiro_servico_comissoes';
    protected $fillable = [
        'barbeiro_id',
        'filial_id',
        'produto_id',
        'tipo_comissao',
        'valor_comissao'
    ];

    protected $casts = [
        'valor_comissao' => 'decimal:2'
    ];

    public function barbeiro()
    {
        return $this->belongsTo(Barbeiro::class);
    }

    public function filial()
    {
        return $this->belongsTo(Filial::class);
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}
