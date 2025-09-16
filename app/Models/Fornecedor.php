<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    use HasFactory;

    protected $table = 'fornecedores';

    protected $fillable = [
        'nome',
        'nome_fantasia',
        'cpf_cnpj',
        'endereco',
        'ativo',
        'pessoa_fisica_juridica',
        'user_created'
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'pessoa_fisica_juridica' => 'string'
    ];

    public function userCreated()
    {
        return $this->belongsTo(User::class, 'user_created');
    }

    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }

    public function scopePessoaFisica($query)
    {
        return $query->where('pessoa_fisica_juridica', 'F');
    }

    public function scopePessoaJuridica($query)
    {
        return $query->where('pessoa_fisica_juridica', 'J');
    }
}
