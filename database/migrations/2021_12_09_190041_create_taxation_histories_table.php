<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxationHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxation_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id');
            $table->foreignId('client_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->date('settlement_date')->nullable();
            $table->foreignId('file_id');
            $table->date('recognition_date')->nullable();
            $table->date('proposal_date')->nullable();
            $table->string('company_representative')->nullable();
            $table->string('accounting_office_staff')->nullable();
            $table->string('video_contributor')->nullable();
            $table->string('comment')->nullable();
            $table->string('kinds');
            $table->string('video_url');
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
        Schema::dropIfExists('taxation_histories');
    }
}
