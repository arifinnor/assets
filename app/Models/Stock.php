<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    public const TIPE_IN = 'in';
    public const TIPE_OUT = 'out';

    protected $fillable = [
        'item_id',
        'qty',
        'tipe',
        'keterangan',
    ];

    public static function getTipe(): array
    {
        return [
            self::TIPE_IN,
            self::TIPE_OUT,
        ];
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
