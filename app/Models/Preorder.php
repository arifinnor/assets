<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Preorder extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'kode',
        'tanggal',
        'partner_id'
    ];

    public function preorderItems(): HasMany
    {
        return $this->hasMany(PreorderItem::class, 'preorder_id');
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class, 'partner_id');
    }

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function (self $model) {
            $latest = $model->latest()->first();
            $po = "PO";
            $periode = date('Y-m');
            $number = $latest ?? 1;

            // $model->kode = "PO/2022-01/0001";
            $model->kode = $po . '/' . $periode . '/' . str_pad((int)$number, 4, '0', STR_PAD_LEFT);
        });
    }
}
