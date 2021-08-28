<?php

namespace App\Http\Requests;

use App\Models\Group;
use App\Models\Institution;

class ChildrenCreateRequest extends ChildrenRequest
{
    public function rules()
    {
        return [
            "fio"=> "required|string|max:200",
            "address"=> "required|string",
            "fio_mother"=> "required|string|max:200",
            "phone_mother"=> "required|string",
            "fio_father"=> "required|string|max:200",
            "phone_father"=> "required|string",
            "comment"=> "required|string",
            "rate"=> "required|string",
            "date_exclusion"=> "required|date",
            "reason_exclusion"=> "required|string",
            "date_birth"=> "required|date",
            "date_enrollment"=> "required|date",
            "group_id"=> "bail|required|string|exists:".Group::class.",id",
            "institution_id"=> "bail|required|string|exists:".Institution::class.",id",
        ];
    }
}
