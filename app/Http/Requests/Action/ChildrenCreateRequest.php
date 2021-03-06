<?php

namespace App\Http\Requests\Action;

use App\Http\Requests\RequestAttribute\ChildrenRequest;
use App\Models\Group;
use App\Models\Types\Institution;

class ChildrenCreateRequest extends ChildrenRequest
{
    public function rules()
    {
        return [
            "fio" => "required|string|max:200",
            "address" => "required|string",
            "fio_mother" => "nullable|string|max:200",
            "phone_mother" => "nullable|string",
            "fio_father" => "nullable|string|max:200",
            "phone_father" => "nullable|string",
            "comment" => "nullable|string",
            "rate" => "required|integer",
            "date_exclusion" => "date",
            "reason_exclusion" => "string",
            "date_birth" => "required|date",
            "date_enrollment" => "required|date",
            "group_id" => "bail|required|integer|exists:" . Group::class . ",id",
            "institution_id" => "bail|required|integer|exists:" . Institution::class . ",id",
        ];
    }
}
