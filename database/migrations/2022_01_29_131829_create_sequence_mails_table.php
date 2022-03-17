<?php

use Domain\Mail\Models\Sequence\Sequence;
use Domain\Mail\Enums\Sequence\SequenceMailStatus;
use Domain\Mail\Models\Sequence\SequenceMailSchedule;
use Domain\Shared\Models\User;
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
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->string('subject');
            $table->text('content');
            $table->string('status')->default(SequenceMailStatus::Draft->value);
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
