<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Children extends Model
{
    use HasFactory;

     //<editor-fold desc="Setting">
    //</editor-fold>

    //<editor-fold desc="Get Attribute">
    public function getId()
    {
        return $this->id;
    }

    public function getFio()
    {
        return $this->fio;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getFioMother()
    {
        return $this->fio_mother;
    }

    public function getPhoneMother()
    {
        return $this->phone_mother;
    }

    public function getFioFather()
    {
        return $this->fio_father;
    }

    public function getPhoneFather()
    {
        return $this->phone_father;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function getRate()
    {
        return $this->rate;
    }

    public function getContract()
    {
        return $this->contract;
    }

    public function getDateExclusion()
    {
        return $this->date_exclusion;
    }

    public function getReasonExclusion()
    {
        return $this->reason_exclusion;
    }

    public function getDateBirth()
    {
        return $this->date_birth;
    }

    public function getDateEnrollment()
    {
        return $this->date_enrollment;
    }

    public function getGroup(): Group
    {
        return Group::getGroupById($this->group_id);
    }

    public function getInstitution(): Institution
    {
        return Institution::getInstitutionById($this->institution_id);
    }
    //</editor-fold>

    //<editor-fold desc="Set Attribute">
    public function setFioIfNotEmpty($fio)
    {
        if ($fio!="") $this->fio = $fio;
    }

    public function setAddressIfNotEmpty($address)
    {
        if ($address!="") $this->address = $address;
    }

    public function setFioMotherIfNotEmpty($fio_mother)
    {
        if ($fio_mother!="") $this->fio_mother = $fio_mother;
    }

    public function setPhoneMotherIfNotEmpty($phone_mother)
    {
        if ($phone_mother!="") $this->phone_mother = $phone_mother;
    }

    public function setFioFatherIfNotEmpty($fio_father)
    {
        if ($fio_father!="") $this->fio_father = $fio_father;
    }

    public function setPhoneFatherIfNotEmpty($phone_father)
    {
        if ($phone_father!="") $this->phone_father = $phone_father;
    }

    public function setCommentIfNotEmpty($comment)
    {
        if ($comment!="") $this->comment = $comment;
    }

    public function setRateIfNotEmpty($rate)
    {
        if ($rate!="") $this->rate = $rate;
    }

    public function setDateExclusionIfNotEmpty($date_exclusion)
    {
        if ($date_exclusion!="") $this->date_exclusion = $date_exclusion;
    }

    public function setReasonExclusionIfNotEmpty($reason_exclusion)
    {
        if ($reason_exclusion!="") $this->reason_exclusion = $reason_exclusion;
    }

    public function setDateBirthIfNotEmpty($date_birth)
    {
        if ($date_birth!="") $this->date_birth = $date_birth;
    }

    public function setDateEnrollmentIfNotEmpty($date_enrollment)
    {
        if ($date_enrollment!="") $this->date_enrollment = $date_enrollment;
    }

    public function setGroupIfNotEmpty(Group $group)
    {
        if ($group->exists) $this->group = $group->getId();
    }

    public function setInstitutionIfNotEmpty(Institution $institution)
    {
        if ($institution->exists) $this->group = $institution->getId();
    }
    //</editor-fold>

    public static function create($name, $address, $fio_mother, $phone_mother, $fio_father,
    $phone_father, $comment, $rate, $date_exclusion, $reason_exclusion, $date_birth, $date_enrollment,
    Group $group, Institution $institution)
    {
        return Group::factory([
            "fio"=>$name,
            "address"=>$address,
            "fio_mother"=>$fio_mother,
            "phone_mother"=>$phone_mother,
            "fio_father"=>$fio_father,
            "phone_father"=>$phone_father,
            "comment"=>$comment,
            "rate"=>$rate,
            "date_exclusion"=>$date_exclusion,
            "reason_exclusion"=>$reason_exclusion,
            "date_birth"=>$date_birth,
            "date_enrollment"=>$date_enrollment,
            "group_id"=>$group->getId(),
            "institution_id"=>$institution->getId(),
        ] )->make();
    }
}
