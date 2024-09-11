<?php

use App\Models\Animal;
use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\TreatmentCategory;
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
        Schema::create('treatments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Doctor::class);
            $table->foreignIdFor(MedicalRecord::class);
            $table->foreignIdFor(TreatmentCategory::class);
            $table->date('treatment_start_date');
            $table->date('treatment_end_date');
            $table->text('description')->nullable();
            $table->integer('dosage');
            $table->float('cost');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treatments');
    }
};