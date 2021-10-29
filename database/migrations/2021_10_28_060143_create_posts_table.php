<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('accounting_office_staff_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('client_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->tinyInteger('is_global')->default(1);
            $table->date('notification_date')->nullable();
            $table->string('subject');
            $table->text('details');
            $table->string('file_name');
            $table->string('file_path');
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
        Schema::dropIfExists('posts');
    }
}
