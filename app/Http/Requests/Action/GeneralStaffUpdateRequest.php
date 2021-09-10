<?php

namespace App\Http\Requests\Action;

use App\Http\Requests\RequestAttribute\GeneralStaffRequest;

class GeneralStaffUpdateRequest extends GeneralStaffRequest
{
    public function rules()
    {
        return [
            "advance_payment" => "integer|min:0",
            "reduction_salary" => "integer|min:0",
            "increase_salary" => "integer|min:0",
            "comment" => "nullable|string",
        ];
    }
}
