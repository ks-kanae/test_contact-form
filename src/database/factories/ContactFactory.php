<?php
namespace Database\Factories;

use App\Models\Contact;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Contact::class;

    public function definition()
    {
        return [
            'first_name' => $this->faker->lastName(),
            'last_name'  => $this->faker->firstName(),
            'gender'     => $this->faker->randomElement([1, 2]),
            'email'      => $this->faker->unique()->safeEmail(),
            'tel'        => $this->faker->numerify('090########'),
            'address'    => $this->faker->prefecture() . $this->faker->city(),
            'building'   => $this->faker->optional()->secondaryAddress(),
            'category_id'=> Category::inRandomOrder()->first()->id,
            'detail'     => $this->faker->realText(50),
        ];
    }
}
