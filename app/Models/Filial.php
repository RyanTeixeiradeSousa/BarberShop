<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filial extends Model
{
    use HasFactory;

    protected $table = 'filiais';

    protected $fillable = [
        'nome',
        'nome_fantasia',
        'cnpj',
        'endereco',
        'telefone',
        'email',
        'ativo',
        'disponivel_site'
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'disponivel_site' => 'boolean'
    ];

    public function getStatusAttribute()
    {
        return $this->ativo ? 'Ativo' : 'Inativo';
    }

    public function getCnpjFormatadoAttribute()
    {
        if (!$this->cnpj) return '';
        return preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $this->cnpj);
    }

    public function barbeiros()
    {
        return $this->belongsToMany(Barbeiro::class, 'barbeiro_filial');
    }
}
