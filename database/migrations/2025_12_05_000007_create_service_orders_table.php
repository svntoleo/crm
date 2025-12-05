<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_orders', function (Blueprint $table) {
            $table->id();
            $table->string('number')->nullable()->index();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('stage_id')->constrained('service_orders_stages')->cascadeOnDelete();
            $table->string('title')->nullable();
            $table->text('notes')->nullable();
            $table->decimal('total', 12, 2)->default(0);
            $table->unsignedInteger('position')->default(0);
            $table->timestamp('scheduled_datetime')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('service_orders', function (Blueprint $table) {
            $table->index(['stage_id', 'position']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_orders');
    }
};
