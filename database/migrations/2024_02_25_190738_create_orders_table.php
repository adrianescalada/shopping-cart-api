<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    protected $connection = 'mysql';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->connection)->create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number');
            $table->json('customer');
            $table->json('products');
            $table->decimal('total_amount', 8, 2);
            $table->json('payment');
            $table->json('shipping_address');
            $table->json('billing_address');
            $table->json('links');
            $table->timestamps();
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
