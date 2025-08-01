<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->date('start_date');
            $table->string('type', 20);
            $table->string('sub_type_1', 20)->nullable();
            $table->unsignedTinyInteger('number_of_sets_1')->nullable();
            $table->unsignedSmallInteger('number_of_reps_1')->nullable();
            $table->unsignedSmallInteger('weight_1')->nullable();
            $table->string('sub_type_2', 20)->nullable();
            $table->unsignedTinyInteger('number_of_sets_2')->nullable();
            $table->unsignedSmallInteger('number_of_reps_2')->nullable();
            $table->unsignedSmallInteger('weight_2')->nullable();
            $table->string('sub_type_3', 20)->nullable();
            $table->unsignedTinyInteger('number_of_sets_3')->nullable();
            $table->unsignedSmallInteger('number_of_reps_3')->nullable();
            $table->unsignedSmallInteger('weight_3')->nullable();
            $table->unsignedSmallInteger('distance')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
