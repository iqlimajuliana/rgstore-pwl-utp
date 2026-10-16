<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    protected $fillable = [
        'name',
        'description',
        'currency',
        'is_active',
    ];

    public function topupPackages(): HasMany
    {
        return $this->hasMany(TopupPackage::class);
    }
}