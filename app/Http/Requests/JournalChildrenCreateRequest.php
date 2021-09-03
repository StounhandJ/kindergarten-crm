<?php

namespace App\Http\Requests;

use App\Models\Visit;

class JournalChildrenCreateRequest extends JournalChildrenRequest
{
    public function rules()
    {
        return [
            "visit_id"=>"bail|required|exists:".Visit::class.",id"
        ];
    }
}
