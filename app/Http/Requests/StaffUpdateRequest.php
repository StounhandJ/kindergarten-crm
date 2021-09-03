<?php

namespace App\Http\Requests;

use App\Models\Group;
use App\Models\Position;

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
            "address"=> "string",
            "phone"=> "string",
            "date_birth"=> "date",
            "date_employment"=> "date",
            "date_dismissal"=> "date",
            "reason_dismissal"=> "date",
            "group_id"=> "bail|string|exists:".Group::class.",id",
            "position_id"=> "bail|string|exists:".Position::class.",id"
        ];
    }
}
