<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuracao extends Model
{
    use HasFactory;

    protected $table = 'configuracoes';

    protected $fillable = [
        'chave',
        'valor',
        'descricao',
        'user_created'
    ];

    public static function get($chave, $default = null)
    {
        $config = self::where('chave', $chave)->first();
        return $config ? $config->valor : $default;
    }

    public static function set($chave, $valor, $descricao = null)
    {
        return self::updateOrCreate(
            ['chave' => $chave],
            ['valor' => $valor, 'descricao' => $descricao]
        );
    }
}
