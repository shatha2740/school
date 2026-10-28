<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lessons', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('course_id')->constrained()->restrictOnDelete();
            $table->string('title');
            $table->longText('content')->nullable();
            $table->string('video_url')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
            $table->index(['course_id', 'sort_order']);
        });

        Schema::create('enrollments', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->restrictOnDelete();
            $table->foreignId('course_id')->constrained()->restrictOnDelete();
            $table->string('status', 24)->default('pending');
            $table->timestamp('enrolled_at')->useCurrent();
            $table->timestamps();
            $table->unique(['user_id', 'course_id']);
            $table->index(['course_id', 'status']);
            $table->index(['user_id', 'status']);
        });

        Schema::create('assignments', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('course_id')->constrained()->restrictOnDelete();
            $table->string('title');
            $table->text('instructions');
            $table->decimal('max_score', 8, 2);
            $table->dateTime('due_at')->nullable();
            $table->timestamps();
            $table->index(['course_id', 'due_at']);
        });

        Schema::create('assignment_submissions', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('assignment_id')->constrained()->restrictOnDelete();
            $table->foreignId('user_id')->constrained()->restrictOnDelete();
            $table->longText('answer')->nullable();
            $table->string('file_path')->nullable();
            $table->decimal('score', 8, 2)->nullable();
            $table->text('instructor_feedback')->nullable();
            $table->string('status', 24)->default('submitted');
            $table->timestamp('submitted_at')->useCurrent();
            $table->timestamp('graded_at')->nullable();
            $table->timestamps();
            $table->unique(['assignment_id', 'user_id']);
            $table->index(['status', 'submitted_at']);
        });

        Schema::create('payments', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('enrollment_id')->constrained()->restrictOnDelete();
            $table->foreignId('user_id')->constrained()->restrictOnDelete();
            $table->decimal('amount', 10, 2);
            $table->string('method', 32)->default('manual');
            $table->string('status', 24)->default('pending');
            $table->string('reference')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('confirmed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
            $table->index(['status', 'paid_at']);
            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
        Schema::dropIfExists('assignment_submissions');
        Schema::dropIfExists('assignments');
        Schema::dropIfExists('enrollments');
        Schema::dropIfExists('lessons');
    }
};
