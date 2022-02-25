<?php

use Domain\Mail\Models\Sequence\Sequence;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSequenceSubscriberTable extends Migration
{
    public function up()
    {
        Schema::create('sequence_subscriber', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Sequence::class)->references('id')->on('sequences');
            $table->foreignIdFor(Subscriber::class)->references('id')->on('subscribers');
            $table->dateTime('subscribed_at')->useCurrent();

            $table->unique(['sequence_id', 'subscriber_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sequence_subscriber');
    }
}
