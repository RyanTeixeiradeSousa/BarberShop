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
        'data_agendamento',
        'hora_inicio',
        'hora_fim',
        'status',
        'observacoes',
        'valor_total',
        'ativo'
    ];

    protected $casts = [
        'data_agendamento' => 'date',
        'hora_inicio' => 'datetime:H:i',
        'hora_fim' => 'datetime:H:i',
        'valor_total' => 'decimal:2',
        'ativo' => 'boolean'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function produtos()
    {
        return $this->belongsToMany(Produto::class, 'agendamento_produto')
                    ->withPivot('quantidade', 'valor_unitario')
                    ->withTimestamps();
    }

    public function movimentacoesFinanceiras()
    {
        return $this->hasMany(MovimentacaoFinanceira::class);
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'disponivel' => 'Disponível',
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
            'disponivel' => 'success',
            'agendado' => 'warning',
            'confirmado' => 'info',
            'em_andamento' => 'primary',
            'concluido' => 'success',
            'cancelado' => 'danger'
        ];

        return $colors[$this->status] ?? 'secondary';
    }

    public function isSlotDisponivel()
    {
        return $this->status === 'disponivel' && is_null($this->cliente_id);
    }

    // public function associarClienteServicos($clienteId, $servicos, $observacoes = null)
    // {
    //     $valorTotal = 0;
        
    //     // Associar cliente
    //     $this->cliente_id = $clienteId;
    //     $this->observacoes = $observacoes;
    //     $this->status = 'agendado';
        
    //     // Associar serviços
    //     $servicosData = [];
    //     foreach ($servicos as $servico) {
    //         $produto = Produto::find($servico['produto_id']);
    //         if ($produto) {
    //             $quantidade = $servico['quantidade'] ?? 1;
    //             $valorUnitario = $produto->preco;
    //             $servicosData[$servico['produto_id']] = [
    //                 'quantidade' => $quantidade,
    //                 'valor_unitario' => $valorUnitario
    //             ];
    //             $valorTotal += $quantidade * $valorUnitario;
    //         }
    //     }
        
    //     $this->valor_total = $valorTotal;
    //     $this->save();
        
    //     // Sincronizar produtos
    //     $this->produtos()->sync($servicosData);
    // }

    public function calcularValorTotal()
    {
        return $this->produtos()->sum(\DB::raw('quantidade * valor_unitario'));
    }

    public function temServicos()
    {
        return $this->produtos()->count() > 0;
    }
}
