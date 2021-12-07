<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('accounting_office_id')->constraint()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('subscription_plan_id')->constraint()->onUpdate('cascade')->onDelete('cascade');
            $table->string('stripe_id')->unique();
            $table->string('stripe_status');
            $table->string('customer_id');
            $table->string('stripe_price')->nullable();
            $table->integer('quantity')->nullable();
            $table->timestamp('trial_start')->nullable();
            $table->timestamp('trial_ends')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
}
