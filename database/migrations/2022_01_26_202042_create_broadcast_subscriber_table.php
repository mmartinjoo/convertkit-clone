<?php

use Domain\Broadcast\Models\Broadcast;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBroadcastSubscriberTable extends Migration
{
    public function up()
    {
        Schema::create('broadcast_subscriber', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Broadcast::class)->constrained();
            $table->foreignIdFor(Subscriber::class)->constrained();
            $table->dateTime('sent_at')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('broadcast_subscriber');
    }
}
