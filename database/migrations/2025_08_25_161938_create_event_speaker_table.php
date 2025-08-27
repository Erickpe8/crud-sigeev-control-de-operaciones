<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('event_speaker')) {
            Schema::create('event_speaker', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('event_id');
                $table->unsignedBigInteger('speaker_id');
                $table->timestamps();

                // Garantiza pares únicos y buen performance
                $table->unique(['event_id','speaker_id']);
                $table->index('event_id');
                $table->index('speaker_id');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('event_speaker');
    }
};
