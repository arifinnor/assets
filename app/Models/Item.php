<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const TIPE_ASET_TETAP = 'aset_tetap';
    public const TIPE_ASET_LANCAR = 'aset_lancar';

    protected $fillable = [
        'nama',
        'tipe'
    ];

    public static function getTipe(): array
    {
        return [
            self::TIPE_ASET_LANCAR,
            self::TIPE_ASET_TETAP
        ];
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}
