<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('phone', 20);
            $table->string('whatsapp_number', 20);
            $table->string('address', 255);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};