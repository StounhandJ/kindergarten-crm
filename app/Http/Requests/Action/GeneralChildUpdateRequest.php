<?php

namespace App\Http\Requests\Action;

use App\Http\Requests\RequestAttribute\GeneralChildRequest;

class GeneralChildUpdateRequest extends GeneralChildRequest
{
    public function rules()
    {
        return [
            "reduction_fees" => "integer|min:0",
            "increase_fees" => "integer|min:0",
            "comment" => "nullable|string",
            "notification" => "boolean"
        ];
    }
}
