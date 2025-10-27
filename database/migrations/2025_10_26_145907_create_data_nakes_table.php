<?php
// database/migrations/2024_01_01_000000_create_data_nakes_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('data_nakes', function (Blueprint $table) {
            $table->id();
            $table->date('admitted_date');
            $table->string('nama');
            $table->enum('status', ['Dokter', 'Perawat', 'Laboran']);
            $table->string('contact');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('data_nakes');
    }
};