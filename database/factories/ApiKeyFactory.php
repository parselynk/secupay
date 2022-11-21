<?php

namespace Database\Factories;

use App\Models\PeriodSpecification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ApiKey>
 */
class ApiKeyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'apiKey' => Str::random(),
            'vertrag_id' => $this->faker->numerify('####'),
            'zeitraum_id' => PeriodSpecification::factory(),
            'ist_masterkey' => true,
            'bearbeiter_id' => User::factory(),
            'timestamp' => Carbon::now()->toDateTimeString(),
        ];
    }
}
