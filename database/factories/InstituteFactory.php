<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Institute>
 */
class InstituteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {   
        $categories = ['sekretariat daerah', 'sekretariat dprd', 'dinas', 'lembaga teknis daerah', 'kecamatan', 'kelurahan'];

        $name = fake()->words(rand(2, 5), true);
        return [
            'name'   => Str::title($name),
            'slug'   => Str::slug($name),
            'abbrev' => Str::upper(fake()->unique()->word()),
            'category' => $categories[rand(0, 5)],
        ];
    }
}
