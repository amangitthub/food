<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('user_id');

            $table->enum('method', ['cash', 'online'])->default('cash');

            $table->string('gateway', 50)->nullable();

            $table->string('gateway_order_id')->nullable();
            $table->string('gateway_payment_id')->nullable();
            $table->string('gateway_signature')->nullable();

            $table->decimal('amount', 10, 2);

            $table->enum('status', [
                'Pending',
                'Success',
                'Failed',
                'Refunded'
            ])->default('Pending');

            $table->longText('response')->nullable();
            $table->longText('proof_document')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};