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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_code')->unique();
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->foreignId('game_id')
                ->constrained('games')
                ->cascadeOnDelete();
            $table->foreignId('package_id')
                ->constrained('topup_packages')
                ->cascadeOnDelete();
            $table->string('user_game_id');
            $table->string('zone_id')->nullable();
            $table->string('payment_method');
            $table->string('amount');
            $table->decimal('total_price', 12, 2);
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
