<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;

    protected $table = 'Rol'; // Nombre de la tabla en la base de datos

    protected $fillable = ['nombre_rol']; //campos de la tabla rol
    protected $primaryKey = 'id_rol';
    public $timestamps = false;
}
