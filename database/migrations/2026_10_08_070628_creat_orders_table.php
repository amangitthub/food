<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->string('order_no', 100);

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('address_id');

            $table->decimal('subtotal', 10, 2)->default(0.00);
            $table->decimal('discount', 10, 2)->default(0.00);
            $table->decimal('shipping', 10, 2)->default(0.00);
            $table->decimal('total', 10, 2)->default(0.00);

            $table->text('notes')->nullable();

            $table->decimal('discount_percentage', 5, 2)->default(0.00);

            $table->decimal('cgst_percentage', 5, 2)->default(0.00);
            $table->decimal('cgst', 10, 2)->default(0.00);

            $table->decimal('sgst_percentage', 5, 2)->default(0.00);
            $table->decimal('sgst', 10, 2)->default(0.00);

            $table->decimal('igst_percentage', 5, 2)->default(0.00);
            $table->decimal('igst', 10, 2)->default(0.00);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};