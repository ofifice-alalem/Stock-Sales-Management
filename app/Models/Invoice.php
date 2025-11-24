<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    protected $fillable = [
        'invoice_number',
        'marketer_id',
        'store_id',
        'total_amount',
        'sent_to_whatsapp',
    ];

    protected function casts(): array
    {
        return [
            'total_amount' => 'decimal:2',
            'sent_to_whatsapp' => 'boolean',
        ];
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function marketer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'marketer_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function debts(): HasMany
    {
        return $this->hasMany(StoreDebt::class);
    }

    public function getTotalAmountAttribute($value): float
    {
        if ($this->relationLoaded('items') && $this->items->isNotEmpty()) {
            return (float) $this->items->sum(fn($item) => $item->price * $item->quantity);
        }
        return (float) ($value ?? 0);
    }
}