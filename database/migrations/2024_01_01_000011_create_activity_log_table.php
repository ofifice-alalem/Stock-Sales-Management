<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_log', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('action_type', 50);
            $table->string('reference_table', 50);
            $table->integer('reference_id');
            $table->foreignId('product_id')->nullable()->constrained('products');
            $table->foreignId('marketer_id')->nullable()->constrained('users');
            $table->foreignId('store_id')->nullable()->constrained('stores');
            $table->integer('quantity')->nullable();
            $table->integer('old_quantity')->nullable();
            $table->integer('new_quantity')->nullable();
            $table->text('description');
            $table->timestamp('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_log');
    }
};