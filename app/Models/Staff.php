<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    use HasFactory, SoftDeletes;

    //<editor-fold desc="Setting">
    protected $hidden = ['delete_at'];

    protected $appends = ['branch_id', "branch_name", "group_name", "position_name"];

    public function getBranchIdAttribute()
    {
        return $this->getGroup()->getBranch()->getId();
    }

    public function getBranchNameAttribute(): string
    {
        return $this->getGroup()->getBranch()->getName();
    }

    public function getGroupNameAttribute(): string
    {
        return $this->getGroup()->getName();
    }

    public function getPositionNameAttribute(): string
    {
        return $this->getPosition()->getName();
    }
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

    public function getPhone()
    {
        return $this->phone;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getDateBirth()
    {
        return $this->date_birth;
    }

    public function getDateEmployment()
    {
        return $this->date_employment;
    }

    public function getDateDismissal()
    {
        return $this->date_dismissal;
    }

    public function getReasonDismissal()
    {
        return $this->reason_dismissal;
    }

    public function getGroup()
    {
        return $this->belongsTo(Group::class, "group_id")->getResults();
    }

    public function getPosition()
    {
        return $this->belongsTo(Position::class, "position_id")->getResults();
    }
    //</editor-fold>

    //<editor-fold desc="Set Attribute">
    public function setFioIfNotEmpty($fio)
    {
        if ($fio!="") $this->fio = $fio;
    }

    public function setPhoneIfNotEmpty($phone)
    {
        if ($phone!="") $this->phone = $phone;
    }

    public function setAddressIfNotEmpty($address)
    {
        if ($address!="") $this->address = $address;
    }

    public function setDateBirthIfNotEmpty($date_birth)
    {
        if ($date_birth!="") $this->date_birth = $date_birth;
    }

    public function setDateEmploymentIfNotEmpty($date_employment)
    {
        if ($date_employment!="") $this->date_employment = $date_employment;
    }

    public function setDateDismissalIfNotEmpty($date_dismissal)
    {
        if ($date_dismissal!="") $this->date_dismissal = $date_dismissal;
    }

    public function setReasonDismissalIfNotEmpty($reason_dismissal)
    {
        if ($reason_dismissal!="") $this->reason_dismissal = $reason_dismissal;
    }

    public function setGroupIfNotEmpty(Group $group)
    {
        if ($group->exists) $this->group_id = $group->getId();
    }

    public function setPositionIfNotEmpty(Position $position)
    {
        if ($position->exists) $this->position_id = $position->getId();
    }
    //</editor-fold>

    //<editor-fold desc="Search Branch">
    public static function getById($id) : Branch
    {
        return Branch::where("id", $id)->first() ?? new Branch();
    }
    //</editor-fold>

    public static function make($fio, $phone, $address, $date_birth, $date_employment, $date_dismissal, $reason_dismissal, Group $group, Position $position)
    {
        return Branch::factory([
            "fio"=>$fio,
            "phone"=>$phone,
            "address"=>$address,
            "date_birth"=>$date_birth,
            "date_employment"=>$date_employment,
            "date_dismissal"=>$date_dismissal,
            "reason_dismissal"=>$reason_dismissal,
            "group_id"=>$group->getId(),
            "position_id"=>$position->getId(),
        ])->make();
    }
}
