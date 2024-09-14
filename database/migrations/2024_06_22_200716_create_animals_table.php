<?php

use App\Models\AnimalCategory;
use App\Models\User;
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
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(AnimalCategory::class);
            $table->string('name');
            $table->string('animal_type');
            $table->integer('age')->comment('age in months');
            $table->float('weight');
            $table->enum('gender', ['male', 'female'])->default('male');
            $table->string('backColor')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};