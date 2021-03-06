<?php

namespace App\Http\Requests\Action;

use App\Http\Requests\RequestAttribute\CategoryCostRequest;

class CategoryCostCreateRequest extends CategoryCostRequest
{
    public function rules()
    {
        return [
            "name" => "required|string|min:1|max:60",
            "is_profit" => "in:true,false",
            "is_set_child" => "in:true,false",
            "is_set_staff" => "in:true,false"
        ];
    }
}
