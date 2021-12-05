<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientMajorNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_major_notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('client_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->boolean('establishment_notification')->default(false);
            $table->boolean('blue_declaration')->default(false);
            $table->boolean('withholding_tax')->default(false);
            $table->boolean('extension_filing_deadline')->default(false);
            $table->boolean('consumption_tax')->default(false);
            $table->boolean('consumption_tax_excemption')->default(false);
            $table->boolean('consumption_tax_selection')->default(false);
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
        Schema::dropIfExists('client_major_notifications');
    }
}
