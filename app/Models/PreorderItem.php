<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Hash;

class PreorderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'preorder_id',
        'variant_id',
        'quantity',
        'ordered_for',
    ];

    protected $hidden = [
        'preorder_id',
    ];

    protected $with = [
        'user',
        'variants',
    ];

    protected $casts = [
        'quantity' => 'float',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ordered_for');
    }

    public function variants(): HasMany
    {
        return $this->hasMany(Variant::class, 'id', 'variant_id');
    }
}
