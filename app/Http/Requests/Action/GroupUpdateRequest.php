<?php

namespace App\Http\Requests\Action;

use App\Http\Requests\RequestAttribute\GroupRequest;
use App\Models\Branch;

class GroupUpdateRequest extends GroupRequest
{
    public function rules()
    {
        return [
            "name"=> "string|min:1|max:60",
            "children_age"=> "integer",
            "branch_id"=> "bail|exists:".Branch::class.",id"
        ];
    }
}
