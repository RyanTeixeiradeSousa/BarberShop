<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BarbeiroComissao;
use App\Models\BarbeiroServicoComissao;

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
        'ativo'
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
        return $this->belongsToMany(Filial::class, 'barbeiro_filial')
                    ->withTimestamps();
    }

    public function comissoes()
    {
        return $this->hasMany(BarbeiroComissao::class);
    }

    public function servicoComissoes()
    {
        return $this->hasMany(BarbeiroServicoComissao::class);
    }

    public function getComissaoFilial($filialId)
    {
        return $this->comissoes()
                    ->where('filial_id', $filialId)
                    ->first();
    }

    public function getComissoesServicos($filialId)
    {
        return $this->servicoComissoes()
                    ->where('filial_id', $filialId)
                    ->with('produto')
                    ->get();
    }
}
