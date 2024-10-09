<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\DTOs\BestSellersOptions;
use App\Rules\MultipleOfTwenty;

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
        return [
            'isbn' => ['array'],
            // The strings must be either 10 or 13 characters long.
            'isbn.*' => ['regex:/^\d{10}$|^\d{13}$/'],
            'author' => ['string'],
            'title' => ['string'],
            'offset' => [new MultipleOfTwenty],
        ];
    }

    public function toDTO()
    {
        return BestSellersOptions::fromArray($this->validated());
    }

}
