<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Modo
 *
 * @property $id
 * @property $nombre
 * @property $intervalo
 * @property $cantidad_intervalo
 * @property $created_at
 * @property $updated_at
 *
 * @property Sesion[] $sesions
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Modo extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre', 'intervalo', 'cantidad_intervalo'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sesions()
    {
        return $this->hasMany(\App\Models\Sesion::class, 'id', 'modo_id');
    }
    
}
