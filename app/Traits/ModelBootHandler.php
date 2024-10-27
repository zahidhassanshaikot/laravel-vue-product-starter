<?php

namespace App\Traits;

trait ModelBootHandler
{
    public static function booted()
    {
        parent::boot();

        static::creating(function($model){
            $model->created_by = auth()->id() ?? null;
        });

        static::updating(function($model){
            $model->updated_by = auth()->id() ?? null;
        });
    }
}
