<?php

namespace App\Http\Requests\Comment;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ReplayRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('api')->check();
    }

    public function rules(): array
    {
        if ($this->routeIs('comment.makeReplay')) {
            return [
                'body' => ['required', 'string', 'min:2', 'max:255'],
                'parent_id' => ['required', 'integer', 'exists:comments,id'],
            ];
        }



        return [];
    }
public function messages(): array
{
    if ($this->routeIs('comment.reply')) {
        return [
            'body.required'     => 'Reply body is required when replying to a comment.',
            'body.string'       => 'Reply body must be a string.',
            'body.min'          => 'Reply must be at least 2 characters.',
            'body.max'          => 'Reply must not exceed 255 characters.',

            'parent_id.required' => 'Parent comment ID is required for a reply.',
            'parent_id.integer'  => 'Parent ID must be an integer.',
            'parent_id.exists'   => 'The parent comment does not exist.',
        ];
    }

 

    return [];
}

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'errors' => $validator->errors(),
            ], 422)
        );
    }
}
