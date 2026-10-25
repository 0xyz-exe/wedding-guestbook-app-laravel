<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wedding_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('bride_name');
            $table->string('groom_name');
            $table->string('slug')->unique();
            $table->date('event_date');
            $table->string('event_time')->default('10:00 AM');
            $table->string('venue_name');
            $table->text('venue_address')->nullable();
            $table->text('story')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wedding_events');
    }
};
