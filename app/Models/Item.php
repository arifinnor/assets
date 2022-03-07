<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use ReflectionClass;

class Item extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const TIPE_ASET_TETAP = 'aset_tetap';
    public const TIPE_ASET_LANCAR = 'aset_lancar';

    public const TIPE_KIB_A = 'kib_a';
    public const TIPE_KIB_B = 'kib_b';
    public const TIPE_KIB_C = 'kib_c';
    public const TIPE_KIB_D = 'kib_d';

    protected $fillable = [
        'nama',
        'tipe_aset',
        'tipe',
    ];

    public static function getTipeAset(): array
    {
        return [
            self::TIPE_ASET_LANCAR,
            self::TIPE_ASET_TETAP
        ];
    }

    public static function getTipe(): array
    {
        $reflector = new ReflectionClass(self::class);

        return array_values(Arr::where($reflector->getConstants(), function ($value) {
            return Str::startsWith($value, 'kib_');
        }));
    }

    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(Variant::class);
    }
}
