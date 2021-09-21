<?php

namespace App\Http\Requests\Action;

use App\Http\Requests\RequestAttribute\GroupRequest;
use App\Models\Branch;

class BranchUpdateRequest extends GroupRequest
{
    public function rules()
    {
        return [
            "name"=> "string|min:1|max:60",
        ];
    }
}
