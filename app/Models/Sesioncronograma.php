<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Sesioncronograma
 *
 * @property $id
 * @property $sesion_id
 * @property $fecha
 * @property $observaciones
 * @property $fecha_pago
 * @property $monto_entregado
 * @property $procesado
 * @property $created_at
 * @property $updated_at
 *
 * @property Sesion $sesion
 * @property Sesionparticipante[] $sesionparticipantes
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Sesioncronograma extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['sesion_id', 'fecha', 'observaciones', 'fecha_pago', 'monto_entregado', 'procesado'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sesion()
    {
        return $this->belongsTo(\App\Models\Sesion::class, 'sesion_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sesionparticipantes()
    {
        return $this->hasOne(\App\Models\Sesionparticipante::class, 'sesioncronograma_id', 'id');
    }
    
}
