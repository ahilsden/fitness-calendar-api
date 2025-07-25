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
        Schema::create('strava_activities', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('strava_id')->unique();
            $table->string('start_date');
            $table->string('name', 100);
            $table->string('type', 20);
            $table->decimal('distance');
            $table->integer('average_heartrate');
            $table->integer('max_heartrate');
            $table->integer('moving_time');
            $table->integer('elapsed_time');
            $table->text('map_polyline')->nullable();
            $table->json('start_latlng')->nullable();
            $table->json('end_latlng')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('strava_activities');
    }
};
