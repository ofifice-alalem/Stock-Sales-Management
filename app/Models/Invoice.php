<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}