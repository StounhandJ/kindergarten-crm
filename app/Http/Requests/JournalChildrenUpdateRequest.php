<?php

namespace App\Http\Requests;

use App\Models\Visit;

class JournalChildrenUpdateRequest extends JournalChildrenRequest
{
    public function rules()
    {
        return [
            "visit_id"=>"bail|exists:".Visit::class.",id"
        ];
    }
}
