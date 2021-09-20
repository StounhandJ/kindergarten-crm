<?php

namespace App\Models;


use App\Models\Types\Institution;
use App\Models\Types\Visit;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Child extends Model
{
    use HasFactory;
    use SoftDeletes;

    //<editor-fold desc="Setting">
    protected $hidden = ['deleted_at', 'created_at', 'updated_at'];

    protected $appends = ['branch_id', "branch_name", "institution_name", "group_name", "date_exclusion"];

    public function getBranchIdAttribute()
    {
        return $this->getGroup()->getBranch()->getId();
    }

    public function getBranchNameAttribute()
    {
        return $this->getGroup()->getBranch()->getName();
    }

    public function getInstitutionNameAttribute()
    {
        return $this->getInstitution()->getName();
    }

    public function getGroupNameAttribute()
    {
        return $this->getGroup()->getName();
    }

    public function getDateExclusionAttribute()
    {
        return $this->getDateExclusion();
    }

    //</editor-fold>

    //<editor-fold desc="Get Attribute">
    public function getJournal(): HasMany
    {
        return $this->hasMany(JournalChild::class);
    }

    /**
     * @param Carbon $data
     * @return Collection|JournalChild[]
     */
    public function getJournalOnMonth(Carbon $data): Collection|array
    {
        return $this->getJournal()->whereDate("create_date", ">=", $data->firstOfMonth())
            ->whereDate("create_date", "<=", $data->lastOfMonth())->get()->sortBy("create_date");
    }

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
        return $this->deleted_at;
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
        return Group::getById($this->group_id);
    }

    public function getInstitution(): Institution
    {
        return Institution::getById($this->institution_id);
    }
    //</editor-fold>

    //<editor-fold desc="Set Attribute">
    public function setFioIfNotEmpty($fio)
    {
        if ($fio != "") $this->fio = $fio;
    }

    public function setAddressIfNotEmpty($address)
    {
        if ($address != "") $this->address = $address;
    }

    public function setFioMotherIfNotEmpty($fio_mother)
    {
        if ($fio_mother != "") $this->fio_mother = $fio_mother;
    }

    public function setPhoneMotherIfNotEmpty($phone_mother)
    {
        if ($phone_mother != "") $this->phone_mother = $phone_mother;
    }

    public function setFioFatherIfNotEmpty($fio_father)
    {
        if ($fio_father != "") $this->fio_father = $fio_father;
    }

    public function setPhoneFatherIfNotEmpty($phone_father)
    {
        if ($phone_father != "") $this->phone_father = $phone_father;
    }

    public function setCommentIfNotEmpty($comment)
    {
        if ($comment != "") $this->comment = $comment;
    }

    public function setRateIfNotEmpty($rate)
    {
        if ($rate != "") $this->rate = $rate;
    }

    public function setDateExclusion($deleted_at)
    {
        $this->deleted_at = $deleted_at;
    }

    public function setReasonExclusionIfNotEmpty($reason_exclusion)
    {
        if ($reason_exclusion != "") $this->reason_exclusion = $reason_exclusion;
    }

    public function setDateBirthIfNotEmpty($date_birth)
    {
        if ($date_birth != "") $this->date_birth = $date_birth;
    }

    public function setDateEnrollmentIfNotEmpty($date_enrollment)
    {
        if ($date_enrollment != "") $this->date_enrollment = $date_enrollment;
    }

    public function setGroupIfNotEmpty(Group $group)
    {
        if ($group->exists) $this->group_id = $group->getId();
    }

    public function setInstitutionIfNotEmpty(Institution $institution)
    {
        if ($institution->exists) $this->institution_id = $institution->getId();
    }
    //</editor-fold>

    //<editor-fold desc="Search Branch">
    public static function getById($id): Child
    {
        return Child::where("id", $id)->first() ?? new Child();
    }

    //</editor-fold>

    public static function make($name, $address, $fio_mother, $phone_mother, $fio_father,
        $phone_father, $comment, $rate, $date_exclusion, $reason_exclusion, $date_birth, $date_enrollment,
                                Group $group, Institution $institution)
    {
        return Child::factory([
            "fio" => $name,
            "address" => $address,
            "fio_mother" => $fio_mother,
            "phone_mother" => $phone_mother,
            "fio_father" => $fio_father,
            "phone_father" => $phone_father,
            "comment" => $comment,
            "rate" => $rate,
            "deleted_at" => $date_exclusion,
            "reason_exclusion" => $reason_exclusion,
            "date_birth" => $date_birth,
            "date_enrollment" => $date_enrollment,
            "group_id" => $group->getId(),
            "institution_id" => $institution->getId(),
        ])->make();
    }
}
