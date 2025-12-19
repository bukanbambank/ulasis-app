<?php

namespace Database\Factories;

use App\Models\Questionnaire;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Questionnaire>
 */
class QuestionnaireFactory extends Factory
{
    protected $model = Questionnaire::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tenant_id' => function () {
                $t = Tenant::create(['id' => \Illuminate\Support\Str::uuid()]);
                return $t->id;
            },
            'title' => $this->faker->sentence(3),
            'template_type' => 'custom',
            'questions' => [
                [
                    'id' => 'q1',
                    'text' => 'How was your experience?',
                    'type' => 'rating',
                    'options' => [],
                    'required' => true,
                ]
            ],
            'is_active' => true,
        ];
    }
}
