<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Agendamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'produto_id',
        'data_agendamento',
        'hora_inicio',
        'hora_fim',
        'status',
        'observacoes',
        'valor',
        'ativo'
    ];

    protected $casts = [
        'data_agendamento' => 'date',
        'hora_inicio' => 'datetime:H:i',
        'hora_fim' => 'datetime:H:i',
        'valor' => 'decimal:2',
        'ativo' => 'boolean'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'agendado' => 'Agendado',
            'confirmado' => 'Confirmado',
            'em_andamento' => 'Em Andamento',
            'concluido' => 'Concluído',
            'cancelado' => 'Cancelado'
        ];

        return $labels[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute()
    {
        $colors = [
            'agendado' => 'warning',
            'confirmado' => 'info',
            'em_andamento' => 'primary',
            'concluido' => 'success',
            'cancelado' => 'danger'
        ];

        return $colors[$this->status] ?? 'secondary';
    }
}
