<?php

use Domain\Automation\Models\Automation;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutomationStepsTable extends Migration
{
    public function up()
    {
        Schema::create('automation_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Automation::class)->constrained()->cascadeOnDelete();
            $table->string('type');
            $table->string('name');
            $table->json('value');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('automation_steps');
    }
}
