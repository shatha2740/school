<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class GradeSubmissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('submissions.grade');
    }


    public function rules(): array
    {


        $maxScore = $this->route('submission')->assignment->max_score ?? 100;

        return [
            'score' => [
                'required',
                'numeric',
                'min:0',
                'max:' . $maxScore,
            ],
            'instructor_feedback' => ['nullable', 'string', 'max:10000'],
              ];
    }
}
