<?php

namespace Database\Factories;

use App\Models\OfferCategory;
use App\Models\BusinessUnit;

use Illuminate\Database\Eloquent\Factories\Factory;

class OfferCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OfferCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        'bu_id' => BusinessUnit::where('name','HJH')->pluck('id')->first(),

        ];
    }
}
