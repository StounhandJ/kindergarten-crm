<?php

namespace App\Http\Requests\Action;

use App\Http\Requests\RequestAttribute\GroupRequest;
use App\Models\Branch;

class GroupCreateRequest extends GroupRequest
{
    public function rules()
    {
        return [
            "name"=> "required|string|min:1|max:60",
            "children_age"=> "required|integer",
            "branch_id"=> "bail|required|exists:".Branch::class.",id"
        ];
    }
}
