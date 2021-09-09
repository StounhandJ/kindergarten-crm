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
            "address"=> "string",
            "phone"=> "string",
            "date_birth"=> "date",
            "date_employment"=> "date",
            "date_dismissal"=> "date",
            "reason_dismissal"=> "date",
            "group_id"=> "bail|nullable|integer|exists:".Group::class.",id",
            "position_id"=> "bail|integer|exists:".Position::class.",id"
        ];
    }
}
