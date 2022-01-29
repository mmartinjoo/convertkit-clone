<?php

use Domain\Subscriber\Models\Subscriber;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSentMailsTable extends Migration
{
    public function up()
    {
        Schema::create('sent_mails', function (Blueprint $table) {
            $table->id();
            $table->integer('mailable_id');
            $table->string('mailable_type');
            $table->foreignIdFor(Subscriber::class)->constrained();
            $table->dateTime('sent_at')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sent_mails');
    }
}
