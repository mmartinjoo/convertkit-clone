<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTrackingColumnsToSentMailsTable extends Migration
{
    public function up()
    {
        Schema::table('sent_mails', function (Blueprint $table) {
            $table->dateTime('opened_at')->nullable();
            $table->dateTime('clicked_at')->nullable();

            $table->index('opened_at');
            $table->index('clicked_at');
            $table->index('sent_at');
        });
    }
}
