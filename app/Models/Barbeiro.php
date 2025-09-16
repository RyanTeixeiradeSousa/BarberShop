<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barbeiro extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'data_nascimento',
        'cpf',
        'rg',
        'endereco',
        'telefone',
        'email',
        'user_id',
        'ativo',
        'user_created'
    ];

    protected $casts = [
        'data_nascimento' => 'date',
        'ativo' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class);
    }

    public function filiais()
    {
        return $this->belongsToMany(Filial::class, 'barbeiro_filial');
    }
}
