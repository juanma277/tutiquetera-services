<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'compras';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['metodo', 'user_id', 'producto_id'];

}
