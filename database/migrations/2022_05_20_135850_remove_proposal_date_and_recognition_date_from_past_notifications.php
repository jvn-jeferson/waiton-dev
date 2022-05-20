<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveProposalDateAndRecognitionDateFromPastNotifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('past_notifications', function (Blueprint $table) {
            $table->dropColumn('proposal_date');
            $table->dropColumn('recognition_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('past_notifications', function (Blueprint $table) {
            //
        });
    }
}
