<?php

use App\Models\Enums\PaymentStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->uuid('device_uuid');

            $table->string('mollie_id')->nullable();

            $table->string('method')->nullable();
            $table->string('issuer')->nullable();

            $table->double('amount', 8, 2);
            $table->string('description');

            $table->string('url')->nullable();
            $table->enum('status', array_map(fn ($status) => $status->value, PaymentStatus::cases()))->default(PaymentStatus::OPEN->value);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
