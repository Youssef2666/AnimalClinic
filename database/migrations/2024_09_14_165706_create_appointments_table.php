<?php

use App\Enums\AppointmentInterviewStatus;
use App\Enums\AppointmentStatus;
use App\Enums\AppointmentTypeStatus;
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
            $table->foreignIdFor(Doctor::class, 'user_id');
            $table->foreignIdFor(Animal::class);
            $table->date('date');
            $table->time('time');
            $table->enum('interview', array_column(AppointmentInterviewStatus::cases(), 'value'));
            $table->enum('status', array_column(AppointmentStatus::cases(), 'value'));
            $table->enum('type', array_column(AppointmentTypeStatus::cases(), 'value'))
            ->default(AppointmentTypeStatus::CONSULTATION->value);
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
