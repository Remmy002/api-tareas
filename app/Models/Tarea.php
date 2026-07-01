<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tarea extends Model
{
    protected $fillable = ['titulo', 'descripcion', 'completada', 'vence_el'];

    protected $casts = [
        'completada' => 'boolean',
        'vence_el'   => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}