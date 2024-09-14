<?php

use App\Models\Animal;
use App\Models\Doctor;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Doctor::class);
            $table->foreignIdFor(Animal::class);
            $table->date('date');
            $table->time('time');
            $table->enum('interview', ['online', 'offline']);
            $table->enum('status', ['confirmed', 'canceled', 'completed'])->default('confirmed');
            $table->enum('type', ['consultation', 'surgery', 'vaccination', 'follow-up'])->default('consultation');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
