<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Sesionparticipante
 *
 * @property $id
 * @property $sesion_id
 * @property $participante_id
 * @property $sesioncronograma_id
 * @property $created_at
 * @property $updated_at
 *
 * @property Participante $participante
 * @property Sesion $sesion
 * @property Sesioncronograma $sesioncronograma
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Sesionparticipante extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['sesion_id', 'participante_id', 'sesioncronograma_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function participante()
    {
        return $this->belongsTo(\App\Models\Participante::class, 'participante_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sesion()
    {
        return $this->belongsTo(\App\Models\Sesion::class, 'sesion_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sesioncronograma()
    {
        return $this->belongsTo(\App\Models\Sesioncronograma::class, 'sesioncronograma_id', 'id');
    }
    
}
