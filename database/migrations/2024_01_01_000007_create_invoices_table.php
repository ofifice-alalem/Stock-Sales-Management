<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number', 50);
            $table->foreignId('marketer_id')->constrained('users');
            $table->foreignId('store_id')->constrained('stores');
            $table->decimal('total_amount', 10, 2)->nullable();
            $table->boolean('sent_to_whatsapp')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};