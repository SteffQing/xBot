<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trades', function (Blueprint $table) {
            $table->id();

            $table->string('exchange_trade_id');

            $table->string('base_pair');
            $table->string('base_pair_price');
            $table->string('base_pair_percentage_change');

            $table->string('pair_traded');
            $table->string('pair_traded_price');

            $table->enum('trade_side', ['BUY', 'SELL']);
            $table->string('trade_size');
            $table->string('trade_price');
            $table->string('percentage_change_used');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trades');
    }
};
