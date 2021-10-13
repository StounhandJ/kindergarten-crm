<?php

namespace App\Http\Requests\Action;

use App\Http\Requests\RequestAttribute\CategoryCostRequest;

class CategoryCostCreateRequest extends CategoryCostRequest
{
    public function rules()
    {
        return [
            "name" => "required|string|min:1|max:60",
            "is_profit" => "boolean",
            "is_set_child" => "boolean",
            "is_set_staff" => "boolean"
        ];
    }
}
