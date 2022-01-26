<?php

use Domain\Broadcast\Models\Broadcast;
use Domain\Subscriber\Models\Tag;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBroadcastFiltersTable extends Migration
{
    public function up()
    {
        Schema::create('broadcast_filters', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Broadcast::class)->constrained();
            $table->foreignIdFor(Tag::class)->constrained();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('broadcast_filters');
    }
}
