<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use MarcReichel\IGDBLaravel\Models\Game as Igdb;

class GameFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Game::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        if(config('igdb.enabled')) {
            $igdb = Igdb::select(['name', 'summary', 'id'])
                ->with(['cover' => ['image_id']])
                ->orderBy('first_release_date', 'desc')
                ->whereNotNull('summary')
                ->whereNotNull('cover')
                ->where('aggregated_rating', '>=', 70)
                ->skip(rand(1,1000))
                ->first();
    
            return [
                'name'              =>  $igdb->name,
                'description'       =>  $igdb->summary,
                'igdb_id'           =>  $igdb->id,
                'image'             => 'https://images.igdb.com/igdb/image/upload/t_cover_big/' . $igdb->cover->image_id . '.jpg',
                'igdb_updated'      =>  Carbon::today(),
                'created_user_id'   =>  User::all()->random()->id,
            ];
        } else {
            return [
                'name'              =>  $this->faker->unique()->realText(20),
                'description'       =>  $this->faker->paragraph($nbSentences = 1),
                'created_user_id'   =>  User::all()->random()->id,
            ];
        }
    }
}
