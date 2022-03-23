<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermanentRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permanent_records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('client_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('accounting_office_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('file_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('pdf_file_id')->nullable();
            $table->timestamp('request_sent_at')->nullable();
            $table->bigInteger('request_sent_by_staff_id')->nullable();
            $table->tinyInteger('has_video');
            $table->tinyInteger('with_approval');
            $table->text('comments');
            $table->bigInteger('viewed_by_staff_id');
            $table->timestamp('response_completed_at')->nullable();
            $table->tinyInteger('is_approved');
            $table->timestamp('viewing_date')->nullable();
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
        Schema::dropIfExists('permanent_records');
    }
}
