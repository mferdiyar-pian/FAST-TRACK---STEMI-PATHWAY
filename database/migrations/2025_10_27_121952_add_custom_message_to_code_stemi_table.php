<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('code_stemi', function (Blueprint $table) {
            $table->text('custom_message')->nullable()->after('checklist');
        });
    }

    public function down(): void
    {
        Schema::table('code_stemi', function (Blueprint $table) {
            $table->dropColumn('custom_message');
        });
    }
};