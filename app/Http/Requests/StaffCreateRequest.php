<?php

namespace App\Http\Requests;

use App\Models\Group;
use App\Models\Position;

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
            "address"=> "required|string",
            "phone"=> "required|string",
            "date_birth"=> "required|date",
            "date_employment"=> "required|date",
            "date_dismissal"=> "required|date",
            "reason_dismissal"=> "required|date",
            "group_id"=> "bail|required|string|exists:".Group::class.",id",
            "position_id"=> "bail|required|string|exists:".Position::class.",id"
        ];
    }
}
