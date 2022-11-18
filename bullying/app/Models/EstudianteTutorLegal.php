<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstudianteTutorLegal extends Model
{
    protected $table = 'estudiantes_tutores_legales';
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['id_tutor_legal','id_estudiante'];
}
