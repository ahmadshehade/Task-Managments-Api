<?php

namespace App\Http\Requests\Comment;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CommentRequest extends FormRequest
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
     * @return array|array{body: string[], task_id: string[]}
     */
    public function rules(): array
    {
        if ($this->routeIs('comment.store')) {
            return [
                'body' => ['required', 'string', 'min:2', 'max:255'],
                'task_id' => ['required', 'integer', 'exists:tasks,id'],
            ];
        }

        if ($this->routeIs('comment.update')) {
            return [
                'body' => ['required', 'string', 'min:2', 'max:255'],
                'task_id' => ['sometimes', 'integer', 'exists:tasks,id'],
            ];
        }

        return [];
    }


/**
 * Summary of messages
 * @return array|array{body.max: string, body.min: string, body.required: string, body.string: string, task_id.exists: string, task_id.integer: string, task_id.required: string|array{body.max: string, body.min: string, body.required: string, body.string: string, task_id.exists: string, task_id.integer: string}}
 */
public function messages(): array
{
    if ($this->routeIs('comment.store')) {
        return [
            'body.required'   => 'Body is required when creating a comment.',
            'body.string'     => 'Body must be a string.',
            'body.min'        => 'Body must be at least 2 characters.',
            'body.max'        => 'Body must not exceed 255 characters.',
            'task_id.required'=> 'Task ID is required when creating a comment.',
            'task_id.integer' => 'Task ID must be an integer.',
            'task_id.exists'  => 'The selected task does not exist.',
        ];
    }

    if ($this->routeIs('comment.update')) {
        return [
            'body.required'   => 'Body is required when updating a comment.',
            'body.string'     => 'Body must be a string.',
            'body.min'        => 'Body must be at least 2 characters.',
            'body.max'        => 'Body must not exceed 255 characters.',
            'task_id.integer' => 'Task ID must be an integer when updating.',
            'task_id.exists'  => 'The selected task does not exist.',
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

