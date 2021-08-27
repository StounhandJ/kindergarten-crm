<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TableRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "page"=>"integer|min:1",
            "limit"=>"integer|min:0"
        ];
    }

    public function getPage(): int
    {
        return (int) $this->input("page");
    }

    public function getLimit(): int
    {
        return (int) $this->input("limit");
    }
}
