<?php

use Domain\Subscriber\Models\Form;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFormIdToSubscribersTable extends Migration
{
    public function up()
    {
        Schema::table('subscribers', function (Blueprint $table) {
            $table->foreignIdFor(Form::class)->after('last_name')->constrained();
        });
    }
}
