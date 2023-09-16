<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TourRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2'],
            'user_id' => [Rule::exists('users', 'id')],
            'category_id' => ['required',Rule::exists('categories', 'id')],
            'address' => ['required', 'string'],
            'city' => ['required', 'string'],
            'country' => ['required', 'string'],
            'phone' => ['string'],
            'email' => ['required', 'email'],
            'website' => ['url'],
            'description' => ['required', 'string'],
            'latitude' => ['required', 'numeric'],
            'longtitude' => ['required', 'numeric'],
            'tour_video' => ['required', 'url'],
            'rating' => ['numeric', 'min:0', 'max:5'],
            'price' => ['numeric'],
        ];
    }
}
