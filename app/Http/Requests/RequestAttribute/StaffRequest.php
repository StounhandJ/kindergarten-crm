<?php

namespace App\Http\Requests\RequestAttribute;

use App\Models\Group;
use App\Models\Types\Position;
use Illuminate\Foundation\Http\FormRequest;

class StaffRequest extends FormRequest
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

    public function getFio()
    {
        return $this->input("fio");
    }

    public function getAddress()
    {
        return $this->input("address");
    }

    public function getPhone()
    {
        return $this->input("phone");
    }

    public function getDateBirth()
    {
        return $this->input("date_birth");
    }

    public function getDateEmployment()
    {
        return $this->input("date_employment");
    }

    public function getDateDismissal()
    {
        return $this->input("date_dismissal");
    }

    public function getReasonDismissal()
    {
        return $this->input("reason_dismissal");
    }

    public function getGroup(): Group
    {
        return Group::getById($this->input("group_id"));
    }

    public function getPosition(): Position
    {
        return Position::getById($this->input("position_id"));
    }

}
