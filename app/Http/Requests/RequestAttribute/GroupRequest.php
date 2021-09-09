<?php

namespace App\Http\Requests\RequestAttribute;

use App\Models\Branch;
use Illuminate\Foundation\Http\FormRequest;

class GroupRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function getName()
    {
        return $this->input("name");
    }

    public function getBranch()
    {
        return Branch::getById($this->input("branch_id"));
    }

    public function getChildrenAge()
    {
        return $this->input("children_age");
    }
}
