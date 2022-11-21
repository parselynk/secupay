<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PeriodSpecification>
 */
class PeriodSpecificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'von' => Carbon::now()->addYear()->subYear()->toDateTimeString(),
            'bis' => Carbon::now()->addYear()->toDateTimeString(),
        ];
    }
}
