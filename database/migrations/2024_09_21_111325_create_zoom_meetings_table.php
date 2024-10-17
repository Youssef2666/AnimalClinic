<?php

use App\Models\Appointment;
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
        Schema::create('zoom_meetings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Appointment::class);
            $table->string('meeting_id')->unique();
            $table->text('start_url');
            $table->text('join_url');
            $table->string('topic');
            $table->text('start_time');
            $table->integer('duration')->comment('in minutes');
            $table->string('timezone')->nullable();
            $table->string('password')->nullable();
            $table->string('agenda')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zoom_meetings');
    }
};
