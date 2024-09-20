<?php

use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\SurgeryCategory;
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
        Schema::create('surgeries', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(SurgeryCategory::class);
            $table->foreignIdFor(MedicalRecord::class);
            $table->foreignIdFor(Doctor::class, 'user_id');
            $table->timestamp('surgery_date');   
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surgeries');
    }
};