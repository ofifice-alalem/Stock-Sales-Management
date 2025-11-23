<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('marketer_id')->constrained('users');
            $table->foreignId('product_id')->constrained('products');
            $table->integer('quantity');
            $table->foreignId('approved_by')->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_assignments');
    }
};