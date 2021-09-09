<?php

namespace App\Http\Requests\Action;

use App\Http\Requests\RequestAttribute\CostRequest;

class CostCreateRequest extends CostRequest
{
    public function rules()
    {
        return [
            "amount"=> "required|integer"
        ];
    }
}
