<?php

namespace App\Http\Requests;

use App\DTOs\BestSellersOptions;
use App\Rules\MultipleOfTwenty;
use Illuminate\Foundation\Http\FormRequest;

class BestSellersRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Query params are always strings, so using the 'string'
        // validation rule for something like: author=32424234 will
        // not make a difference. This could be its own rule, but this
        // just shows another way to implement a custom validation rule.
        $mustBeString = function ($attribute, $value, $fail) {
            if (is_numeric($value)) {
                $fail($attribute.' must be a string.');
            }
        };

        return [
            'isbn' => ['array'],
            // The strings must be either 10 or 13 characters long.
            'isbn.*' => ['regex:/^\d{10}$|^\d{13}$/'],
            'author' => [$mustBeString],
            'title' => [$mustBeString],
            'offset' => [new MultipleOfTwenty],
        ];
    }

    public function toDTO()
    {
        return BestSellersOptions::fromArray($this->validated());
    }
}
