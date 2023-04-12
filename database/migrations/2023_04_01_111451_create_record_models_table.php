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
        Schema::create('record_models', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->smallInteger('chat_id')->nullable();
            $table->smallInteger('durak_no')->nullable();
            $table->smallInteger('period')->default(5);
            $table->smallInteger('range_start')->nullable();
            $table->smallInteger('range_end')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('record_models');
    }
};
