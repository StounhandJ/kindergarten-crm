<?php

namespace App\Http\Requests;

use App\Models\Branch;
use Illuminate\Foundation\Http\FormRequest;

class GroupCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name"=> "required|string|min:1|max:60",
            "children_age"=> "required|integer",
            "branch_id"=> "bail|required|exists:".Branch::class.",id"
        ];
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
