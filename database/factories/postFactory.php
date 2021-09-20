<?php

namespace Database\Factories;

use App\Models\Model;
use App\Models\post;
use Illuminate\Database\Eloquent\Factories\Factory;

class postFactory extends Factory
{

    protected $model = post::class;


    public function definition()
    {
        return [
            'post_name' => $this->faker->name(),
            'post_content' => $this->faker->paragraph()

        ];
    }
}
