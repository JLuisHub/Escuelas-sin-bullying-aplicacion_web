<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class TutorLegal extends Authenticatable implements JWTSubject
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tutores_legales';
    protected $fillable = ['email','nombre', 'aPaterno','aMaterno','password'];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    
    public function getJWTCustomClaims()
    {
        return [
            'email' => $this->email,
        ];
    }
    
}
