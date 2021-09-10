<?php

namespace App\Http\Requests\RequestAttribute;

use Illuminate\Foundation\Http\FormRequest;

class GeneralChildRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function getReductionFees()
    {
        return $this->input("reduction_fees");
    }

    public function getIncreaseFees()
    {
        return $this->input("increase_fees");
    }

    public function getComment()
    {
        return $this->input("comment");
    }

    public function getNotification()
    {
        return $this->input("notification");
    }
}
