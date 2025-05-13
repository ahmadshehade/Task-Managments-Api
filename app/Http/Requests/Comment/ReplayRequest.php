<?php

namespace App\Http\Requests\Comment;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ReplayRequest extends FormRequest
{
    /**
     * Summary of authorize
     * @return bool
     */
    public function authorize(): bool
    {
        return auth('api')->check();
    }

    /**
     * Summary of rules
     * @return array|array{body: string[], parent_id: string[]}
     */
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
/**
 * Summary of messages
 * @return array|array{body.max: string, body.min: string, body.required: string, body.string: string, parent_id.exists: string, parent_id.integer: string, parent_id.required: string}
 */
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

    /**
     * Summary of failedValidation
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     * @return never
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'errors' => $validator->errors(),
            ], 422)
        );
    }
}
