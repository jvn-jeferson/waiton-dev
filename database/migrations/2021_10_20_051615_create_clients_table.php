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
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('accounting_office_id');
            $table->string('name')->unique();
            $table->foreignId('business_type_id')->default(1);
            $table->string('address');
            $table->string('telephone');
            $table->string('representative')->unique();
            $table->tinyInteger('tax_filing_month');
            $table->string('nta_num')->unique();
            $table->string('temporary_password');
            $table->timestamp('verified_at')->nullable();
            $table->string('notify_on_ids')->nullable();
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
