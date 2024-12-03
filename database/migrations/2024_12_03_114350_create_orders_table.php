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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            //orders:id,table_id,reservation_id,cusomter_id,waiter_id,total,paid,date
            $table->decimal('total');
            $table->boolean('paid')->default(0);
            
            $table->foreignId('table_id')
                ->constrained('tables')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreignId('customer_id')
                ->constrained('customers')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreignId('waiter_id')
                ->constrained('waiters')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreignId('reservation_id')
                ->constrained('reservations')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();// data
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
