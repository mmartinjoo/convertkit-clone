<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToSequenceSubscriberTable extends Migration
{
    public function up()
    {
        Schema::table('sequence_subscriber', function (Blueprint $table) {
            $table->string('status')->nullable(true)->default(null);
        });
    }

    public function down()
    {
        Schema::table('sequence_subscriber', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
