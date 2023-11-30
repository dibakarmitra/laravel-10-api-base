<?php
namespace App\Traits;

trait ActiveFlagTrait {

    public function scopeActive($query)
    {
        return $query->where('active_flag', 1);
    }

    public function scopeInactive($query)
    {
        return $query->where('active_flag', 0);
    }
}
