<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => 'required',
            'description' => 'required',
            'bannerImageUrl' => 'required',
            'profileImageUrl' => 'required',
            'collectionUrl' => 'required',
            'websiteUrl' => 'required',
            'category' => 'required',
            'type' => 'required',
            'floorPrice' => 'numeric',
            'owners' => 'numeric',
            'averagePrice' => 'numeric',
            'count' => 'numeric',
            'sevenDaySales' => 'numeric',
            'oneDaySales' => 'numeric',
        ];
    }
}
