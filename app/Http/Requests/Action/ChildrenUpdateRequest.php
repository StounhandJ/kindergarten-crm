<?php

namespace App\Http\Requests\Action;

use App\Http\Requests\RequestAttribute\ChildrenRequest;
use App\Models\Group;
use App\Models\Types\Institution;

class ChildrenUpdateRequest extends ChildrenRequest
{
    public function rules()
    {
        return [
            "fio"=> "string|max:200",
            "address"=> "string",
            "fio_mother"=> "string|max:200",
            "phone_mother"=> "string",
            "fio_father"=> "string|max:200",
            "phone_father"=> "string",
            "comment"=> "string",
            "rate"=> "string",
            "date_exclusion"=> "nullable|date",
            "reason_exclusion"=> "string",
            "date_birth"=> "date",
            "date_enrollment"=> "date",
            "group_id"=> "bail|integer|exists:".Group::class.",id",
            "institution_id"=> "bail|integer|exists:".Institution::class.",id",
        ];
    }
}
