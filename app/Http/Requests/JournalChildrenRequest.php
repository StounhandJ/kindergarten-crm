<?php

namespace App\Http\Requests;

use App\Models\Visit;
use Illuminate\Foundation\Http\FormRequest;

class JournalChildrenRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function getVisit(): Visit
    {
        return Visit::getById($this->input("visit_id"));
    }
}
