<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaFinanceira extends Model
{
    use HasFactory;
    protected $table = 'categorias_financeiras';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nome',
        'descricao',
        'tipo',
        'ativo',
        'user_created'
    ];

    protected $casts = [
        'ativo' => 'boolean',
    ];

    public function movimentacoes()
    {
        return $this->hasMany(MovimentacaoFinanceira::class);
    }
}
