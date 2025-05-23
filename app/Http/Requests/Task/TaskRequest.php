<?php

namespace App\Http\Requests\Task;

use App\Rules\ValidDueDate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class TaskRequest extends FormRequest
{
    /**
     * Summary of authorize
     * @return bool
     */
    public function authorize(): bool
    {
        $user = auth('api')->user();
        return $user && $user->rule === 'admin';
    }

    /**
     * Summary of prepareForValidation
     * @return void
     */
    protected function prepareForValidation(): void
    {
        if ($this->title) {
            $this->merge([
                'title' => Str::title($this->title)
            ]);
        }
    }

    /**
     * Summary of rules
     * @return array|array{description: string[], due_date: array<string|ValidDueDate>, name: array<string|\Illuminate\Validation\Rules\In>, priority: string[], title: array<string|\Illuminate\Validation\Rules\Unique>, user_id: string[]|array{description: string[], due_date: array<string|ValidDueDate>, name: array<string|\Illuminate\Validation\Rules\In>, priority: string[], title: string[], user_id: string[]}}
     */
    public function rules(): array
    {
        if ($this->routeIs('task.store')) {
            return [
                'title' => ['required', 'string', 'max:150'],
                'description' => ['required', 'string', 'min:100'],
                'user_id' => ['integer', 'exists:users,id'],
                'due_date' => ['required', 'date', new ValidDueDate()],
                'name' => ['nullable', 'string', 'max:32', Rule::in(['pending', 'in progress', 'completed'])],
                'priority' => ['required', 'in:low,medium,high']
            ];
        }

        if ($this->routeIs('task.update')) {
            return [
                'title' => ['sometimes', 'string', 'max:150', Rule::unique('tasks', 'title')->ignore($this->task)],
                'description' => ['sometimes', 'string', 'min:100'],
                'user_id' => ['sometimes', 'integer', 'exists:users,id'],
                'due_date' => ['sometimes', 'date', new ValidDueDate()],
                'name' => ['required', 'string', 'max:32', Rule::in(['pending', 'in progress', 'completed'])],
                'priority' => ['sometimes', 'in:low,medium,high']
            ];
        }

        return [];
    }

/**
 * Summary of messages
 * @return array|array{description.min: string, description.required: string, description.string: string, due_date.date: string, due_date.required: string, name.in: string, name.max: string, name.string: string, priority.in: string, priority.required: string, title.max: string, title.required: string, title.string: string, user_id.exists: string, user_id.integer: string|array{description.min: string, description.string: string, due_date.date: string, name.in: string, name.max: string, name.required: string, name.string: string, priority.in: string, title.max: string, title.string: string, title.unique: string, user_id.exists: string, user_id.integer: string}}
 */
public function messages(): array
{
    if ($this->routeIs('task.store')) {
        return [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title may not be greater than 150 characters.',

            'description.required' => 'The description field is required.',
            'description.string' => 'The description must be a string.',
            'description.min' => 'The description must be at least 100 characters.',

            'user_id.integer' => 'The user ID must be an integer.',
            'user_id.exists' => 'The selected user does not exist.',

            'due_date.required' => 'The due date is required.',
            'due_date.date' => 'The due date must be a valid date.',

            'name.string' => 'The status must be a string.',
            'name.max' => 'The status may not be greater than 32 characters.',
            'name.in' => 'The status must be one of: pending, in progress, or completed.',

            'priority.required' => 'The priority field is required.',
            'priority.in' => 'The priority must be one of: low, medium, or high.',
        ];
    }

    if ($this->routeIs('task.update')) {
        return [
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title may not be greater than 150 characters.',
            'title.unique' => 'This title has already been taken.',

            'description.string' => 'The description must be a string.',
            'description.min' => 'The description must be at least 100 characters.',

            'user_id.integer' => 'The user ID must be an integer.',
            'user_id.exists' => 'The selected user does not exist.',

            'due_date.date' => 'The due date must be a valid date.',

            'name.required' => 'The status field is required.',
            'name.string' => 'The status must be a string.',
            'name.max' => 'The status may not be greater than 32 characters.',
            'name.in' => 'The status must be one of: pending, in progress, or completed.',

            'priority.in' => 'The priority must be one of: low, medium, or high.',
        ];
    }

    return [];
}


    /**
     * Summary of attributes
     * @return array{description: string, due_date: string, name: string, priority: string, title: string, user_id: string}
     */
    public function attributes(): array
    {
        return [
            'title' => 'task title',
            'description' => 'task description',
            'user_id' => 'user ID',
            'due_date' => 'due date',
            'name' => 'status name',
            'priority' => 'Priority Task'
        ];
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
                'error' => $validator->errors()->all(),
            ], 422)
        );
    }
}
