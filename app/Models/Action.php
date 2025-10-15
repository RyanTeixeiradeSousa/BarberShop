<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    use HasFactory;

    protected $fillable = [
        'controller',
        'method',
        'nome',
        'descricao',
        'ativo',
        'user_id'
    ];

    protected $casts = [
        'ativo' => 'boolean',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_actions');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
