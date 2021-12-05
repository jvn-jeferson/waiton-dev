<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('accounting_office_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string('name')->unique();
            $table->foreignId('business_type_id')->default(1);
            $table->string('address');
            $table->string('representative');
            $table->string('representative_address');
            $table->string('contact_email')->unique();
            $table->tinyInteger('tax_filing_month');
            $table->timestamp('verified_at')->nullable();
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
        Schema::dropIfExists('clients');
    }
}
