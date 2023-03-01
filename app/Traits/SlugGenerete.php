<?php
namespace App\Traits;

use Illuminate\Support\Str;

trait SlugGenerete {
    protected static function boot()
    {
        parent::boot();
        static::creating(function($model) {
            $model->slug = join('-', explode(' ', $model->title)) . '-' . Str::random(10);
        });

        static::updating(function($model) {
            $model->slug = join('-', explode(' ', $model->title)) . '-' . Str::random(10);
        });
    }
}