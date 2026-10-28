<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->string('title_en')->nullable();
            $table->string('title_ar')->nullable();
            $table->string('category_en')->nullable();
            $table->string('category_ar')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->text('short_description_en')->nullable();
            $table->text('short_description_ar')->nullable();
            $table->string('level_en')->nullable();
            $table->string('level_ar')->nullable();
            $table->string('slug_en')->nullable()->unique();
            $table->string('slug_ar')->nullable()->unique();
            $table->foreignId('instructor_id')
                ->nullable()
                ->constrained()
                ->restrictOnDelete();
        });

        DB::table('courses')
            ->select([
                'id',
                'title',
                'slug',
                'category',
                'description',
                'short_description',
                'level',
            ])
            ->orderBy('id')
            ->chunkById(500, function ($courses): void {
                foreach ($courses as $course) {
                    DB::table('courses')
                        ->where('id', $course->id)
                        ->update([
                            'title_en' => $course->title,
                            'category_en' => $course->category,
                            'description_en' => $course->description,
                            'short_description_en' => $course->short_description,
                            'level_en' => $course->level,
                            'slug_en' => $course->slug,
                        ]);
                }
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropForeign(['instructor_id']);
            $table->dropUnique('courses_slug_en_unique');
            $table->dropUnique('courses_slug_ar_unique');
            $table->dropColumn([
                'title_en',
                'title_ar',
                'category_en',
                'category_ar',
                'description_en',
                'description_ar',
                'short_description_en',
                'short_description_ar',
                'level_en',
                'level_ar',
                'slug_en',
                'slug_ar',
                'instructor_id',
            ]);
        });
    }
};
