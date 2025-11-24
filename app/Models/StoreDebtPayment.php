<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StoreDebtPayment extends Model
{
    protected $fillable = [
        'store_id',
        'marketer_id',
        'amount',
        'remaining',
        'note',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'remaining' => 'decimal:2',
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function marketer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'marketer_id');
    }
}
