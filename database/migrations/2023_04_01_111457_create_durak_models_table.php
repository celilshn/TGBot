<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('durak_models', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->smallInteger('chat_id');
            $table->smallInteger('durak');
            $table->smallInteger('range_start');
            $table->smallInteger('range_end');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('durak_models');
    }
};
