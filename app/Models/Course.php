<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;


class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'description',
        'short_description',
        'price',
        'image',
        'duration_weeks',
        'level',
        'is_published',
        'title_en',
        'title_ar',

        'description_en',
        'description_ar',
        'short_description_en',
        'short_description_ar',

        'instructor_id',
    ];

    public function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'duration_weeks' => 'integer',
            'is_published' => 'boolean',
        ];
    }

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(Instructor::class);
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class)->orderBy('sort_order');
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'enrollments')
            ->withPivot(['id', 'status', 'enrolled_at'])
            ->withTimestamps();
    }

    public function payments(): HasManyThrough
    {
        return $this->hasManyThrough(Payment::class, Enrollment::class);
    }
public function imageUrl()
{
    return asset( $this->image);
}
    public function localized(string $attribute): ?string
    {
        $locale = str_starts_with(app()->getLocale(), 'ar') ? 'ar' : 'en';
        $otherLocale = $locale === 'ar' ? 'en' : 'ar';

        return $this->getAttribute("{$attribute}_{$locale}")
            ?: $this->getAttribute($attribute)
            ?: $this->getAttribute("{$attribute}_{$otherLocale}");
    }
}
