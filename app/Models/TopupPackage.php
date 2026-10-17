<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TopupPackage extends Model
{
    protected $fillable = [
        'game_id',
        'amount',
        'price',
        'is_active',
    ];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'package_id');
    }
}