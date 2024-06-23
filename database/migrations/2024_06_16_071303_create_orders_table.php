<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->json('selected_services'); // Storing selected services as JSON
            $table->string('status')->default('Pending');
            $table->string('user_location');
            $table->string('notes');
            $table->decimal('minimum_total_price', 10, 2);
            $table->timestamps();
            // Foreign key constraint
            $table->index('user_id');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
