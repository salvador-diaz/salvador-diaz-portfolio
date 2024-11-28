<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Por defecto asumirá tabla _users_ con primary key _id_ incremental.
 * No es necesario nombrar las columnas de la tabla. A menos que se desee
 * algún control específico sobre ellas.
 *
 * @see https://laravel.com/docs/11.x/eloquent
 */
class User extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'google_id',
    ];

}
