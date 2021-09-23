<?php

namespace App\Http\Requests\Action;

use App\Http\Requests\RequestAttribute\JournalChildrenRequest;
use App\Models\Types\Visit;

class JournalChildrenUpdateRequest extends JournalChildrenRequest
{
    public function rules()
    {
        return [
            "visit_id" => "bail|exists:" . Visit::class . ",id"
        ];
    }
}
