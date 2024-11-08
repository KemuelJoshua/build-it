<?php

namespace Database\Factories;

use App\Models\BreakDown;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BreakdownFactory extends Factory
{
    protected $model = BreakDown::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Generate a random square meter value within a reasonable range
        $sqm = $this->faker->numberBetween(50, 300);

        // Apply the logic for calculating the budget
        if ($sqm >= 50 && $sqm <= 99) {
            $minBudget = 2500000;
            $maxBudget = 3500000;
        } elseif ($sqm >= 100 && $sqm <= 149) {
            $minBudget = 4000000;
            $maxBudget = 5000000;
        } elseif ($sqm >= 150 && $sqm <= 199) {
            $minBudget = 6000000;
            $maxBudget = 7000000;
        } elseif ($sqm >= 200 && $sqm <= 300) {
            $minBudget = 8000000;
            $maxBudget = 10000000;
        } else {
            // Default budget for invalid sqm values (this case should not happen based on the input range)
            $minBudget = 0;
            $maxBudget = 0;
        }

        // Generate random budget within the range
        $budget = $this->faker->randomFloat(2, $minBudget, $maxBudget);

        // Generate a random date between today and 10 yeas ago
        // $randomDate = $this->faker->dateTimeBetween('-12 months', 'now');
        $randomDate = $this->faker->dateTimeBetween('-10 years', 'now');

        return [
            'sqm' => $sqm,
            'budget' => $budget,
            'created_at' => $randomDate,
            'updated_at' => $randomDate, // you can use the same date for `updated_at`, or generate a different one
        ];
    }
}