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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->time('from_time');
            $table->time('to_time');
            $table->date('reservation_date');
            $table->foreignId('table_id')
                ->constrained('tables')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreignId('customer_id')
                ->constrained('customers')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
