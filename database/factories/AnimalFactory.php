<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Animal;
use App\Models\MedicalRecord;
use App\Models\AnimalCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Animal>
 */
class AnimalFactory extends Factory
{
    protected $model = Animal::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(), // You can associate it with a user factory
            'animal_category_id' => AnimalCategory::factory(), // Assuming there's a factory for this too
            'animal_type' => $this->faker->randomElement(['Dog', 'Cat', 'Bird']),
            'name' => $this->faker->name(),
            'age' => $this->faker->numberBetween(1, 15),
            'weight' => $this->faker->numberBetween(1, 30),
            'gender' => $this->faker->randomElement(['male', 'female']),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Animal $animal) {
            // Automatically create a medical record after creating the animal
            MedicalRecord::create([
                'animal_id' => $animal->id,
                'notes' => 'This is a generated medical record'
            ]);
        });
    }
}
