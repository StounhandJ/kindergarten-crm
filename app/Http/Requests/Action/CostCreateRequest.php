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
            "amount" => "required|integer|min:0",
            "income" => "required|boolean",
            "comment" => "nullable|string",
            "month" => "required|date",
            "child_id" => "bail|nullable|integer|exists:" . Child::class . ",id",
            "staff_id" => "bail|nullable|integer|exists:" . Staff::class . ",id",
        ];
    }
}
