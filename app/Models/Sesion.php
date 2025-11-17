<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class Sesion
 *
 * @property $id
 * @property $nombre_sesion
 * @property $fecha_inicio
 * @property $fecha_fin
 * @property $cuota
 * @property $modo_id
 * @property $estado
 * @property $created_at
 * @property $updated_at
 *
 * @property Modo $modo
 * @property Sesioncronograma[] $sesioncronogramas
 * @property Sesionparticipante[] $sesionparticipantes
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Sesion extends Model
{

    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre_sesion', 'fecha_inicio', 'fecha_fin', 'cuota', 'qrcobro', 'modo_id', 'estado'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function modo()
    {
        return $this->belongsTo(\App\Models\Modo::class, 'modo_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sesioncronogramas()
    {
        return $this->hasMany(\App\Models\Sesioncronograma::class, 'sesion_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sesionparticipantes()
    {
        return $this->hasMany(\App\Models\Sesionparticipante::class, 'sesion_id', 'id');
    }

    public static function getEstados()
{
    $table = (new static)->getTable();
    $column = 'estado';

    $type = \DB::selectOne("SHOW COLUMNS FROM {$table} WHERE Field = '{$column}'")->Type;

    preg_match("/^enum\('(.*)'\)$/", $type, $matches);

    return explode("','", $matches[1]);
}
}
