<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
            $table->date('startDate');
            $table->string('type', 20);
            $table->string('subType1', 20);
            $table->unsignedTinyInteger('numberOfSets1');
            $table->unsignedSmallInteger('numberOfReps1');
            $table->unsignedSmallInteger('weight1');
            $table->string('subType2', 20);
            $table->unsignedTinyInteger('numberOfSets2');
            $table->unsignedSmallInteger('numberOfReps2');
            $table->unsignedSmallInteger('weight2');
            $table->string('subType3', 20);
            $table->unsignedTinyInteger('numberOfSets3');
            $table->unsignedSmallInteger('numberOfReps3');
            $table->unsignedSmallInteger('weight3');
            $table->unsignedSmallInteger('distance');
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
