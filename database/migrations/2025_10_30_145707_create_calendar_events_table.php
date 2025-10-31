<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('calendar_events', function (Blueprint $table) {
            $table->id();
            $table->date('event_date');
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('status', ['running', 'finished'])->default('running');
            $table->string('patient_name')->nullable();
            $table->string('doctor_name')->nullable();
            $table->timestamps();
            
            $table->index('event_date');
            $table->index('status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('calendar_events');
    }
};