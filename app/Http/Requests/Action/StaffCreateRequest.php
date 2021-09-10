<?php

namespace App\Http\Requests\Action;

use App\Http\Requests\RequestAttribute\StaffRequest;
use App\Models\Group;
use App\Models\Types\Position;

class StaffCreateRequest extends StaffRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "fio"=> "required|string|max:200",
            "login" => "required|string|unique:users,login",
            "password" => "required|string",
            "address"=> "required|string",
            "phone"=> "required|string",
            "date_birth"=> "required|date",
            "date_employment"=> "required|date",
            "date_dismissal"=> "date",
            "reason_dismissal"=> "string",
            "group_id"=> "bail|nullable|integer|exists:".Group::class.",id",
            "position_id"=> "bail|required|integer|exists:".Position::class.",id"
        ];
    }
}
