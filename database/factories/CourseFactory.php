<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(3);
        $slug = fake()->unique()->slug();
        $category = fake()->word();
        $description = fake()->paragraph(3);
        $shortDescription = fake()->sentence();
        $level = fake()->randomElement(['beginner', 'intermediate', 'advanced']);

        return [
            'title' => $title,
            'slug' => $slug,
            'category' => $category,
            'description' => $description,
            'short_description' => $shortDescription,
            'price' => fake()->randomFloat(2, 10, 200),
            'image' => null,
            'duration_weeks' => fake()->numberBetween(2, 16),
            'level' => $level,
            'is_published' => true,
            'title_en' => $title,
            'title_ar' => 'عنوان ' . fake()->unique()->word(),
            'category_en' => $category,
            'category_ar' => 'تصنيف',
            'description_en' => $description,
            'description_ar' => 'وصف تفصيلي للكورس.',
            'short_description_en' => $shortDescription,
            'short_description_ar' => 'وصف مختصر للكورس.',
            'level_en' => $level,
            'level_ar' => 'مبتدئ',
            'slug_en' => $slug,
            'slug_ar' => fake()->unique()->slug(),
        ];
    }
}
