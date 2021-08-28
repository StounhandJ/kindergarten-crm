<?php

namespace App\Http\Requests;

use App\Models\Group;
use App\Models\Institution;
use Illuminate\Foundation\Http\FormRequest;

class ChildrenRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function getFio()
    {
        return $this->input("fio");
    }

    public function getAddress()
    {
        return $this->input("address");
    }

    public function getFioMother()
    {
        return $this->input("fio_mother");
    }

    public function getPhoneMother()
    {
        return $this->input("phone_mother");
    }

    public function getFioFather()
    {
        return $this->input("fio_father");
    }

    public function getPhoneFather()
    {
        return $this->input("phone_father");
    }

    public function getComment()
    {
        return $this->input("comment");
    }

    public function getRate()
    {
        return $this->input("rate");
    }

    public function getDateExclusion()
    {
        return $this->input("date_exclusion");
    }

    public function getReasonExclusion()
    {
        return $this->input("reason_exclusion");
    }

    public function getDateBirth()
    {
        return $this->input("date_birth");
    }

    public function getDateEnrollment()
    {
        return $this->input("date_enrollment");
    }

    public function getGroup(): Group
    {
        return Group::getById($this->input("group_id"));
    }

    public function getInstitution(): Institution
    {
        return Institution::getById($this->input("institution_id"));
    }
}
