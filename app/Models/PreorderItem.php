<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PreorderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'preorder_id',
        'item_id',
        'quantity',
        'user_id',
    ];

    protected $hidden = [
        'preorder_id',
    ];

    protected $with = [
        'user',
        'item',
    ];

    protected $casts = [
        'quantity' => 'float',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
