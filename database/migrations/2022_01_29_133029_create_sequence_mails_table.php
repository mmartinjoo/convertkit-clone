<?php

use Domain\Sequence\Models\Sequence;
use Domain\Sequence\Enums\SequenceMailStatus;
use Domain\Sequence\Models\SequenceMailSchedule;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSequenceMailsTable extends Migration
{
    public function up()
    {
        Schema::create('sequence_mails', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Sequence::class)->constrained();
            $table->foreignIdFor(SequenceMailSchedule::class)->constrained();
            $table->string('title');
            $table->text('content');
            $table->string('status')->default(SequenceMailStatus::DRAFT->value);
            $table->json('filters')->nullable(true);
            $table->timestamps();
            $table->index('status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sequence_mails');
    }
}