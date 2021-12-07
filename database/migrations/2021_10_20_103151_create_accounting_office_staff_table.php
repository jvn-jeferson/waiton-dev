<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountingOfficeStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounting_office_staffs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('accounting_office_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->string('name');
            $table->tinyInteger('is_admin')->default(1);
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
        Schema::dropIfExists('accounting_office_staff');
    }
}
