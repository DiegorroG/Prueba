<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departameto extends Model
{
    protected $table='_departamentos';
    protected $fillable=[
        'nombreDepartamento',
        'descripcion'
    ];
}
