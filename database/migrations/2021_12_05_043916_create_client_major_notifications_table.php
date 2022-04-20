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
            $table->boolean('establishment_notification')->default(false)->nullable();
            $table->boolean('blue_declaration')->default(false)->nullable();
            $table->boolean('withholding_tax')->default(false)->nullable();
            $table->boolean('salary_payment')->default(false)->nullable();
            $table->boolean('extension_filing_deadline')->default(false)->nullable();
            $table->boolean('consumption_tax')->default(false)->nullable();
            $table->boolean('consumption_tax_excemption')->default(false)->nullable();
            $table->boolean('consumption_tax_selection')->default(false)->nullable();
            $table->boolean('simple_taxation')->default(false)->nullable();
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
        Schema::dropIfExists('client_major_notifications');
    }
}
