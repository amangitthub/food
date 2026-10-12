<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_status_history', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('order_id');

            $table->enum('status', [
                'pending',
                'packed',
                'picked',
                'shipped',
                'out_for_delivery',
                'complete',
                'cancelled',
                'return_requested',
                'returned',
                'failed',
            ]);

            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();

            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_status_history');
    }
};