<?php

namespace App\Http\Requests\Action;

use App\Http\Requests\RequestAttribute\StaffRequest;
use App\Models\Group;
use App\Models\Types\Position;

class StaffUpdateRequest extends StaffRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "fio"=> "string|max:200",
            "login"=> "string|unique:users,login",
            "password" => "string",
            "address"=> "string",
            "phone"=> "string",
            "date_birth"=> "date",
            "date_employment"=> "date",
            "date_dismissal"=> "nullable|date",
            "reason_dismissal"=> "date",
            "salary" => "integer|min:0",
            "group_id"=> "bail|nullable|integer|exists:".Group::class.",id",
            "position_id"=> "bail|integer|exists:".Position::class.",id"
        ];
    }
}
