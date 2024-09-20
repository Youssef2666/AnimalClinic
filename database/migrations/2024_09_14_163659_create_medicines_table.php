<?php

use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\MedicineCategory;
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
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Doctor::class, 'user_id');
            $table->foreignIdFor(MedicalRecord::class);
            $table->foreignIdFor(MedicineCategory::class);
            $table->string('description')->nullable();            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
