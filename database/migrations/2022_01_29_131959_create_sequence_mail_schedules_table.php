<?php

use Domain\Mail\Models\Sequence\SequenceMail;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSequenceMailSchedulesTable extends Migration
{
    public function up()
    {
        Schema::create('sequence_mail_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(SequenceMail::class)->constrained()->cascadeOnDelete();
            $table->integer('delay');
            $table->string('unit');
            $table->json('allowed_days');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sequence_mail_schedules');
    }
}
