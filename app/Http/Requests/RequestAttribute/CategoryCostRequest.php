<?php

namespace App\Http\Requests\RequestAttribute;

use Illuminate\Foundation\Http\FormRequest;

class CategoryCostRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function getName()
    {
        return $this->input("name");
    }

    public function getIsProfit()
    {
        return $this->input("is_profit");
    }
}
