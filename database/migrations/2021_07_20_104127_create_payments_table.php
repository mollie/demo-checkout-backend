<?php

use App\Models\Payment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
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
            $table->enum('status', [
                Payment::$STATUS_OPEN,
                Payment::$STATUS_CANCELED,
                Payment::$STATUS_PENDING,
                Payment::$STATUS_EXPIRED,
                Payment::$STATUS_FAILED,
                Payment::$STATUS_PAID,
            ])->default('open');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
