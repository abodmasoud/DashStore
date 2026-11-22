<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'number',
        'status',
        'subtotal',
        'discount',
        'shipping',
        'total',
        'shipping_name',
        'shipping_phone',
        'shipping_address',
        'notes',
    ];

    protected $casts = [
        'status' => OrderStatus::class,
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'shipping' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::creating(function (Order $order) {
            $order->number ??= static::generateNumber();
            $order->status ??= OrderStatus::Pending;
        });
    }

    /** Human-friendly order number, e.g. DS-20261122-4F7K. */
    public static function generateNumber(): string
    {
        do {
            $number = 'DS-'.now()->format('Ymd').'-'.Str::upper(Str::random(4));
        } while (static::where('number', $number)->exists());

        return $number;
    }

    /** Includes soft-deleted customers so order history stays intact. */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function scopeStatus(Builder $query, OrderStatus $status): Builder
    {
        return $query->where('status', $status);
    }
}
