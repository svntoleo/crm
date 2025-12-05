<?php

namespace Database\Factories;

use App\Models\QuotationsStage;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuotationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'number' => 'QUO-' . $this->faker->numberBetween(1000, 9999),
            'title' => $this->faker->sentence(),
            'notes' => $this->faker->paragraph(),
            'stage_id' => QuotationsStage::firstOrCreate(
                ['order' => 0],
                ['label' => 'Draft', 'color' => '#808080']
            )->id,
            'total' => 0,
            'position' => 0,
        ];
    }
}
