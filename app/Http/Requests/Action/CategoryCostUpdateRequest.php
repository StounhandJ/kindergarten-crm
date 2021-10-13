<?php

namespace App\Http\Requests\Action;

use App\Http\Requests\RequestAttribute\CategoryCostRequest;
use Illuminate\Foundation\Http\FormRequest;

class CategoryCostUpdateRequest extends CategoryCostRequest
{
    public function rules()
    {
        return [
            "name" => "string|min:1|max:60",
            "is_profit" => "boolean"
        ];
    }
}
