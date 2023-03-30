<?php

namespace Database\Factories;

use App\Models\Offer;
use App\Models\BusinessUnit;
use App\Models\OfferCategory;

use Illuminate\Database\Eloquent\Factories\Factory;

class OfferFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Offer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text,
        'slug' => $this->faker->text,
        'small_description' => $this->faker->text,
        'photo' => $this->faker->word,
        'meta_keywords' => $this->faker->text,
        'meta_description' => $this->faker->text,
        'top_offer' => $this->faker->randomDigitNotNull,
        'price' => $this->faker->randomDigitNotNull,
        'discount_price' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        'image_title' => $this->faker->word,
        'image_alt' => $this->faker->word,
        'order' => $this->faker->randomDigitNotNull,
        'offer_note' => $this->faker->text,
        'status' => 1,
        'start_at' => $this->faker->date('Y-m-d'),
        'end_at' => $this->faker->date('Y-m-d'),
        'campaign' => $this->faker->text,
        'featured' => 0,
        'offer_category_id' => OfferCategory::inRandomorder()->first()->id,
        'bu_id' => BusinessUnit::where('name','HJH')->pluck('id')->first(),

        ];
    }
}
