<?php

namespace Database\Factories;

use App\Models\Institute;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use App\Models\Type;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Legislation>
 */
class LegislationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $title = fake()->sentence(rand(10, 20));
        $number = fake()->numberBetween(1, 100);
        $dateTime = fake()->dateTimeBetween('-2 years');
        $created_at = Carbon::parse($dateTime)->translatedFormat('Y-m-d H:i:s');

        $posted_at = null;
        if (rand(0, 1) === 1) {
            $posted_at = Carbon::parse($dateTime)->addDays(rand(1, 2));
        }

        $revised_at = null;
        if (!empty($posted_at)) {
            if (rand(0, 1) === 1) {
                $revised_at = Carbon::parse($posted_at)->addDays(rand(1, 5));
            }
        }

        $validated_at = null;
        if (!empty($revised_at)) {
            if (rand(0, 1) === 1) {
                $validated_at = Carbon::parse($revised_at)->addDays(rand(1, 3));
            }
        }

        $year = Carbon::parse($created_at)->translatedFormat('Y');

        $institute = Institute::get()->random();
        $users = $institute->users()->pluck('id');
        if (count($users) > 0) {
            $user = $users[rand(0, count($users) - 1)];
        } else {
            $user = User::admin()->get()->random()->id;
        } 

        return [
            'type_id'    => Type::get()->random()->id,
            'title'      => $title,
            'slug'       => Str::slug($title),
            'reg_number' => $number,
            'year'       => $year,
            'institute_id'  => $institute->id,
            'user_id'    => $user,
            'created_at' => $created_at,
            'background' => (rand(0, 1) === 1) ? fake()->paragraph() : null,
            'posted_at'  => $posted_at,    
            'revised_at' => $revised_at,
            'validated_at' => $validated_at,  
        ];
    }
}
