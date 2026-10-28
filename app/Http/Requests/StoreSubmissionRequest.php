<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubmissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {

    return $this->user()->isStudent() || $this->user()->can('submissions.create');
    }


    public function rules(): array
    {
        return [

            'answer' => ['nullable', 'string', 'required_without:file', 'max:50000'],
            'file' => [
                'nullable',
                'file',
                'mimes:pdf,doc,docx,zip',
                'max:10240', // حد أقصى 10 ميجابايت
                'required_without:answer',
            ],
        ];
    }
}
