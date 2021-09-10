<?php

namespace App\Http\Requests\RequestAttribute;

use Illuminate\Foundation\Http\FormRequest;

class GeneralStaffRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function getAdvancePayment()
    {
        return $this->input("advance_payment");
    }

    public function getReductionSalary()
    {
        return $this->input("reduction_salary");
    }

    public function getIncreaseSalary()
    {
        return $this->input("increase_salary");
    }

    public function getComment()
    {
        return $this->input("comment");
    }

}
