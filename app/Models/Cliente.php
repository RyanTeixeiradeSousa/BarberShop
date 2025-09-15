<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'cpf',
        'email',
        'data_nascimento',
        'sexo',
        'ativo',
        'telefone1',
        'telefone2',
        'endereco',
        'user_created'
    ];

    protected $casts = [
        'data_nascimento' => 'date',
        'ativo' => 'boolean'
    ];

    public function getIdadeAttribute()
    {
        return $this->data_nascimento->age;
    }

    public function getSexoFormatadoAttribute()
    {
        return $this->sexo === 'M' ? 'Masculino' : 'Feminino';
    }

    public function getStatusAttribute()
    {
        return $this->ativo ? 'Ativo' : 'Inativo';
    }
}
