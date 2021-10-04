<?php

namespace App\Http\Requests\RequestAttribute;

use App\Models\Child;
use App\Models\Staff;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

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

    public function getComment()
    {
        return $this->input("comment");
    }

    public function getIncome()
    {
        return !($this->input("income") == "0");
    }

    public function getMonth()
    {
        return is_null($this->input("month"))?Carbon::now():Carbon::make($this->input("month"));
    }

    public function getChild(): Child
    {
        return Child::getById($this->input("child_id"));
    }

    public function getStaff(): Staff
    {
        return Staff::getById($this->input("staff_id"));
    }
}
