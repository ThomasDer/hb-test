<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'store_id' => function () {
                return Store::factory()->create()->id;
            },
            'first_name' => $this->faker->name(),
            'phone' => '0' . rand(600000000, 799999999),
            'email' => $this->faker->unique()->safeEmail(),
            'has_optin' => $this->faker->boolean(),
            'created_at' => $this->faker->dateTime(),
            'updated_at' => null,
            'deleted_at' => null,
        ];
    }
}
