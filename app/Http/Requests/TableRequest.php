<?php

namespace App\Http\Requests;

use Carbon\Carbon;
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
            "page" => "integer|min:1",
            "limit" => "integer|min:0",
            "date" => "date"
        ];
    }

    public function getPage(): int
    {
        return (int)$this->input("page");
    }

    public function getLimit(): int
    {
        return (int)$this->input("limit");
    }

    public function getDate(): Carbon
    {
        if ($this->input("date") != null)
            return Carbon::make($this->input("date"));
        return Carbon::now();
    }
}
