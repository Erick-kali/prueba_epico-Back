<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuario'; // Nombre de la tabla en la base de datos

    protected $primaryKey = 'id_usuario'; // Clave primaria de la tabla

    protected $fillable = [
        'nombres',
        'apellidos',
        'email',
        'contrasena',
        'id_rol',
        'numero_intento',
        'id_estado',
        'status',
        'cedula'
    ];

    public $timestamps = false; // no hay campos de creacion ni de actualizacion que queramos de laravel

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'id_estado');
    }

    public function usuarios()
    {
        return $this->hasMany(User::class, 'id_rol');
    }
}
