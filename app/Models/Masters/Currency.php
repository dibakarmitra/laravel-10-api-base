<?php

namespace App\Models\Masters;

use App\Traits\ActiveFlagTrait;
use App\Traits\SetTableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory, SetTableTrait, ActiveFlagTrait;
}
