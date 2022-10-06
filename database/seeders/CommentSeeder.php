<?php

namespace Database\Seeders;

use App\Models\Legislation;
use App\Models\Comment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $legislations = Legislation::all();

        foreach ($legislations as $legislation) {
            if (rand(0, 1)) {
                $created_at = $legislation->created_at;
                for ($i=0; $i < rand(1, 5); $i++) { 
                    $user = [];
                    $user[] = $legislation->user_id;
                    $user[] = $legislation->institute->corrector->id;

                    $new_created_at = Carbon::parse($created_at)->addHours(rand(2, 10));

                    Comment::factory()->create([
                        'legislation_id'    => $legislation->id,
                        'author_id'         => $user[rand(0, 1)],
                        'created_at'        => $new_created_at,
                        'updated_at'        => rand(0, 1) ? Carbon::parse($new_created_at)->addHours(rand(1, 3)) : $new_created_at,
                    ]);
                }
            }
        }
    }
}
