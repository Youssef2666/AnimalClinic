<?php

use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\VaccinationCategory;
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
        Schema::create('vaccinations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(VaccinationCategory::class);
            $table->foreignIdFor(Doctor::class);
            $table->foreignIdFor(MedicalRecord::class);
            $table->date('vaccination_start_date');
            $table->date('vaccination_end_date');
            $table->text('notes')->nullable();
            $table->float('cost');
            $table->integer('dosage');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vaccinations');
    }
};