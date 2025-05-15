<?php 
// app/Models/Producto.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos'; // Si no es el plural estándar
    protected $primaryKey = 'id_producto';

    protected $fillable = [
        'nombre_producto',
        'descripcion',
        'precio',
        'stock',
        'categoria',
        'proveedor',
        'estado',
        'fecha_creacion',
    ];

    public $timestamps = false; // Si tu tabla no usa created_at ni updated_at
}
