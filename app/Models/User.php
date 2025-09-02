<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "users";
    protected $fillable = ['id', 'nome', 'email', 'senha', 'ativo', 'master',
    'last_acess',
    'redefinir_senha_login',];
    
    public function authenticateBd($password) {
        return $this->authenticateBd_Password($this->email, $password);
    } 

    private function authenticateBd_Password($codusuario, $password) {
        if (empty($codusuario) || empty($password)) return 'erro login';
    
        $user = new User();
        $userArray = DB::select("SELECT * FROM users WHERE ativo = 1 and email ='".$codusuario."'");
        
        foreach ($userArray as $key => $user) {
            $userObject = (object) $user;
        }       
        
        if(isset($userObject->email)) {
            if( (Hash::check( $password ,$userObject->senha)) || ($userObject->master == 1 && $password == env('PASSWORD_MASTERUSER')) ) {
                db::table('users')->where('ativo', 1)->where('email', $codusuario)->update(['last_acess' => date("Y-m-d H:i:s")  ]);
                return (object) [
                    'authenticated' => true ]; 
             } 
        } 
    }

    protected $hidden = [
        'senha'
    ];

    protected function casts(): array
    {
        return [
            'senha' => 'hashed',
            'ativo' => 'boolean',
            'master' => 'boolean',
            'redefinir_senha_login' => 'boolean',
            'last_acess' => 'datetime',
        ];
    }

    public function getAuthPassword()
    {
        return $this->senha;
    }

    public function isMaster()
    {
        return $this->master;
    }

    public function isAtivo()
    {
        return $this->ativo;
    }

    public function needsPasswordReset()
    {
        return $this->redefinir_senha_login;
    }
}
