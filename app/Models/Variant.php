<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Variant extends Model
{
    use HasFactory;

    public const STATUS_RECEIVED = "sudah_diterima";
    public const STATUS_NOT_YET_RECEIVED = "belum_diterima";

    protected $fillable = [
        'item_id',
        'status',
        'register',
        'collection'
    ];

    protected $casts = [
        'collection' => 'array',
    ];

    protected $with = [
        'item'
    ];

    /**
     * Get the item that owns the variant.
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function preorderItem(): BelongsTo
    {
        return $this->belongsTo(PreorderItem::class);
    }

    public function preorder()
    {
        return $this->hasOneThrough(Preorder::class, PreorderItem::class);
    }

    /**
     * Method register
     *
     * @param int $item_id
     *
     * @return string
     */
    public static function register(int $item_id)
    {
        $latest = self::where('item_id', $item_id)->latest()->first();
        // $number = $latest ? $latest->register : 0;

        // $model->register = "1.0001";
        return $latest ?
            (int) $latest->number + 1 :
            str_pad((int)$item_id, 4, '0', STR_PAD_LEFT) . '.' . str_pad(1, 4, '0', STR_PAD_LEFT);
    }
}
