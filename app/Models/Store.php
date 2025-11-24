<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'whatsapp_number',
        'address',
    ];

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function debts()
    {
        return $this->hasMany(StoreDebt::class);
    }
}