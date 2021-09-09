<?php

namespace App\Http\Requests\RequestAttribute;

use Illuminate\Foundation\Http\FormRequest;

class CostRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function getAmount()
    {
        return $this->input("amount");
    }
}
