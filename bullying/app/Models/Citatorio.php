<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citatorio extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'citatorios';
    protected $fillable = ['id_docente', 'id_estudiante','descripcion','fecha']; 

}
