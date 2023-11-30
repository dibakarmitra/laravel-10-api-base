<?php
namespace App\Traits;

trait HasUserIDTrait {
    
    /**
     * Boot the trait
     *
     * @return void
     */
    protected function bootHasUserIDTrait()
    {
        static::creating(function ($model) {
            $model->user_id = auth()->id();
        });
    }
}