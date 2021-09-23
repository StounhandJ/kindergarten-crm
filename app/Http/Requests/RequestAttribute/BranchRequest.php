<?php

namespace App\Http\Requests\RequestAttribute;

use App\Models\Branch;
use Illuminate\Foundation\Http\FormRequest;

class BranchRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function getName()
    {
        return $this->input("name");
    }
}
