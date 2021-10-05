<?php

namespace App\Models;


use App\Models\Types\Institution;
use App\Models\Types\Visit;
use App\Services\ChangePhone;
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

    protected $appends = ['branch_id', "branch_name", "institution_name", "group_name", "date_exclusion", "document_url"];

    public function getBranchIdAttribute()
    {
        return $this->getGroup()->getBranch()->getId();
    }

    public function getBranchNameAttribute()
    {
        return $this->getGroup()->getBranch()->getName();
    }

    public function getGroupNameAttribute()
    {
        return $this->getGroup()->getName();
    }

    public function getDateExclusionAttribute()
    {
        return $this->getDateExclusion();
    }

    public function getInstitutionNameAttribute()
    {
        return $this->getInstitution()->getName();
    }

    public function getDocumentUrlAttribute()
    {
        return route("document.child", ["child_id"=>$this->getId()]);
    }

    //</editor-fold>

    //<editor-fold desc="Get Attribute">

    public function getGroup(): Group
    {
        return Group::getById($this->group_id);
    }

    public function getInstitution(): Institution
    {
        return Institution::getById($this->institution_id);
    }

    public function getDateExclusion()
    {
        return $this->deleted_at;
    }

    /**
     * @param Carbon $data
     * @return Collection|JournalChild[]
     */
    public function getJournalOnMonth(Carbon $data): Collection|array
    {
        return $this->getJournal()->whereDate("create_date", ">=", $data->clone()->firstOfMonth())
            ->whereDate("create_date", "<=", $data->clone()->lastOfMonth())->get()->sortBy("create_date");
    }

    public function getJournal(): HasMany
    {
        return $this->hasMany(JournalChild::class);
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

    public function getСleanPhoneMother()
    {
        return ChangePhone::clear($this->getPhoneMother());
    }

    public function getFioFather()
    {
        return $this->fio_father;
    }

    public function getPhoneFather()
    {
        return $this->phone_father;
    }

    public function getСleanPhoneFather()
    {
        return ChangePhone::clear($this->getPhoneFather());
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

    public function getReasonExclusion()
    {
        return $this->reason_exclusion;
    }

    public function getDateBirth(): Carbon
    {
        return Carbon::make($this->date_birth);
    }

    public function getDateEnrollment()
    {
        return $this->date_enrollment;
    }
    //</editor-fold>

    //<editor-fold desc="Set Attribute">

    public function setFioIfNotEmpty($fio): static
    {
        if ($fio != "") {
            $this->fio = $fio;
        }

        return $this;
    }

    public function setAddressIfNotEmpty($address): static
    {
        if ($address != "") {
            $this->address = $address;
        }

        return $this;
    }

    public function setFioMotherIfNotEmpty($fio_mother): static
    {
        if ($fio_mother != "") {
            $this->fio_mother = $fio_mother;
        }

        return $this;
    }

    public function setPhoneMotherIfNotEmpty($phone_mother): static
    {
        if ($phone_mother != "") {
            $this->phone_mother = $phone_mother;
        }

        return $this;
    }

    public function setFioFatherIfNotEmpty($fio_father): static
    {
        if ($fio_father != "") {
            $this->fio_father = $fio_father;
        }

        return $this;
    }

    public function setPhoneFatherIfNotEmpty($phone_father): static
    {
        if ($phone_father != "") {
            $this->phone_father = $phone_father;
        }

        return $this;
    }

    public function setCommentIfNotEmpty($comment): static
    {
        if ($comment != "") {
            $this->comment = $comment;
        }

        return $this;
    }

    public function setRateIfNotEmpty($rate): static
    {
        if ($rate != "") {
            $this->rate = $rate;
        }

        return $this;
    }

    public function setDateExclusion($deleted_at): static
    {
        $this->deleted_at = $deleted_at;

        return $this;
    }

    public function setReasonExclusionIfNotEmpty($reason_exclusion): static
    {
        if ($reason_exclusion != "") {
            $this->reason_exclusion = $reason_exclusion;
        }

        return $this;
    }

    public function setDateBirthIfNotEmpty($date_birth): static
    {
        if ($date_birth != "") {
            $this->date_birth = $date_birth;
        }

        return $this;
    }

    public function setDateEnrollmentIfNotEmpty($date_enrollment): static
    {
        if ($date_enrollment != "") {
            $this->date_enrollment = $date_enrollment;
        }

        return $this;
    }

    public function setGroupIfNotEmpty(Group $group): static
    {
        if ($group->exists) {
            $this->group_id = $group->getId();
        }

        return $this;
    }

    public function setInstitutionIfNotEmpty(Institution $institution): static
    {
        if ($institution->exists) {
            $this->institution_id = $institution->getId();
        }

        return $this;
    }
    //</editor-fold>

    //<editor-fold desc="Search Branch">

    public static function getById($id): Child
    {
        return Child::where("id", $id)->firstOrNew();
    }

    public static function getByGroup(Group $group): Collection
    {
        return Child::query()->where("group_id", $group->getId())->get();
    }

    //</editor-fold>


    public static function make(
        $name,
        $address,
        $fio_mother,
        $phone_mother,
        $fio_father,
        $phone_father,
        $comment,
        $rate,
        $date_exclusion,
        $reason_exclusion,
        $date_birth,
        $date_enrollment,
        Group $group,
        Institution $institution
    ) {
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
