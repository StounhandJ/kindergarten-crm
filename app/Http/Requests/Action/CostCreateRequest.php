<?php

namespace App\Http\Requests\Action;

use App\Http\Requests\RequestAttribute\CostRequest;
use App\Models\Child;
use App\Models\Staff;

class CostCreateRequest extends CostRequest
{
    public function rules()
    {
        return [
            "amount" => "required|integer",
            "comment" => "nullable|string",
            "child_id" => "bail|nullable|integer|exists:".Child::class.",id",
            "staff_id" => "bail|nullable|integer|exists:".Staff::class.",id",
        ];
    }
}