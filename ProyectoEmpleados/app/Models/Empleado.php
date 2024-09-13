<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table='empleados';
    protected $fillable=[
        'nombre',
        'apellidos',
        'celular',
        'email',
        'departamento_id',
    ];
        // Relación con el modelo Departameto
    public function departameto()
    {
        return $this->belongsTo(Departameto::class, 'departamento_id', 'id');
    }
}
