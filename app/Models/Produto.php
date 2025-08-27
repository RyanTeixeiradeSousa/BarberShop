<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
        'preco',
        'estoque',
        'categoria_id',
        'ativo',
        'tipo',
        'imagem',
        'site'
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'site' => 'boolean',
        'preco' => 'decimal:2'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function getPrecoFormatadoAttribute()
    {
        return 'R$ ' . number_format($this->preco, 2, ',', '.');
    }

    public function getTipoFormatadoAttribute()
    {
        return $this->tipo === 'produto' ? 'Produto' : 'Serviço';
    }
}
