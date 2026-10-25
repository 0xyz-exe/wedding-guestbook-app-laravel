<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guestbook_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wedding_event_id')->constrained()->cascadeOnDelete();
            $table->string('guest_name');
            $table->string('guest_email')->nullable();
            $table->string('relationship')->default('Friend'); // Family, Friend, Colleague, Relative
            $table->enum('attendance_status', ['attending', 'declined', 'tentative'])->default('attending');
            $table->integer('pax_count')->default(1);
            $table->text('wishes_message');
            $table->boolean('is_confirmed')->default(false); // Attendance check-in confirmation
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guestbook_entries');
    }
};
