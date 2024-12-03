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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount_to_pay');
            $table->smallInteger('num_meals')->default(1);

            $table->foreignId('order_id')
                ->constrained('orders')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreignId('meal_id')
                ->constrained('meals')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
