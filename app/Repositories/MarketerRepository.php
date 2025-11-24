<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\MarketerRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MarketerRepository implements MarketerRepositoryInterface
{
    private const MARKETER_ROLE_ID = 3;

    public function getMarketersWithStock(?string $search, ?string $sort): Collection
    {
        $query = User::where('role_id', self::MARKETER_ROLE_ID)
            ->where('is_active', true);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $marketers = $query->select('users.id', 'users.name', 'users.phone')
            ->get()
            ->map(function ($marketer) {
                $stock = DB::table('marketer_stock')
                    ->join('products', 'marketer_stock.product_id', '=', 'products.id')
                    ->where('marketer_stock.marketer_id', $marketer->id)
                    ->where('marketer_stock.quantity', '>', 0)
                    ->select('products.name', 'products.price', 'marketer_stock.quantity')
                    ->get();

                $marketer->products = $stock;
                $marketer->total_quantity = $stock->sum('quantity');
                $marketer->total_stock_value = $stock->sum(function ($item) {
                    return $item->quantity * $item->price;
                });
                $marketer->total_invoices = DB::table('invoices')
                    ->where('marketer_id', $marketer->id)
                    ->sum('total_amount');
                
                return $marketer;
            });

        if ($sort === 'total_invoices_desc') {
            $marketers = $marketers->sortByDesc('total_invoices');
        } elseif ($sort === 'total_invoices_asc') {
            $marketers = $marketers->sortBy('total_invoices');
        } elseif ($sort === 'total_stock_value_desc') {
            $marketers = $marketers->sortByDesc('total_stock_value');
        } elseif ($sort === 'total_stock_value_asc') {
            $marketers = $marketers->sortBy('total_stock_value');
        }

        return $marketers->values();
    }

    public function getMarketerStock(int $marketerId): Collection
    {
        return DB::table('marketer_stock')
            ->join('products', 'marketer_stock.product_id', '=', 'products.id')
            ->where('marketer_stock.marketer_id', $marketerId)
            ->where('marketer_stock.quantity', '>', 0)
            ->select('products.id', 'products.name', 'marketer_stock.quantity')
            ->get();
    }

    public function addStock(int $marketerId, int $productId, int $quantity): void
    {
        $existing = DB::table('marketer_stock')
            ->where('marketer_id', $marketerId)
            ->where('product_id', $productId)
            ->first();

        if ($existing) {
            DB::table('marketer_stock')
                ->where('marketer_id', $marketerId)
                ->where('product_id', $productId)
                ->update([
                    'quantity' => $existing->quantity + $quantity,
                    'updated_at' => now()
                ]);
        } else {
            DB::table('marketer_stock')->insert([
                'marketer_id' => $marketerId,
                'product_id' => $productId,
                'quantity' => $quantity,
                'updated_at' => now()
            ]);
        }
    }

    public function removeStock(int $marketerId, int $productId, int $quantity): void
    {
        $existing = DB::table('marketer_stock')
            ->where('marketer_id', $marketerId)
            ->where('product_id', $productId)
            ->first();

        if ($existing) {
            DB::table('marketer_stock')
                ->where('marketer_id', $marketerId)
                ->where('product_id', $productId)
                ->update([
                    'quantity' => $existing->quantity - $quantity,
                    'updated_at' => now()
                ]);
        }
    }
}
