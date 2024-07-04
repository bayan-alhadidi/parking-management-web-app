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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('check_in');
            $table->time('check_out')->nullable();
            $table->enum('payment_status',['paid', 'unpaid'])->default('unpaid');
            $table->string('payment_method')->nullable();
            $table->foreignId('vehicle_id')->constrained('vehicles','id');
            $table->foreignId('slot_id')->constrained('slots','id');
            $table->foreignId('customer_id')->constrained('customers','id');
            $table->foreignId('user_id')->constrained('users','id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
