<?php

namespace App\Models;

use App\Models\Types\Position;
use App\Models\Types\Visit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

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

    public function getBranchNameAttribute()
    {
        return $this->getGroup()->getBranch()->getName();
    }

    public function getGroupNameAttribute()
    {
        return $this->getGroup()->getName();
    }

    public function getPositionNameAttribute()
    {
        return $this->getPosition()->getName();
    }
    //</editor-fold>

    //<editor-fold desc="Get Attribute">
    public function getJournal(): HasMany
    {
        return $this->hasMany(JournalStaff::class);
    }

    public function getJournalOnMonth(Carbon $data): Collection
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
        return $this->belongsTo(Group::class, "group_id")->getResults() ?? new Group();
    }

    public function getPosition()
    {
        return $this->belongsTo(Position::class, "position_id")->getResults();
    }
    //</editor-fold>

    //<editor-fold desc="Set Attribute">
    public function setFioIfNotEmpty($fio)
    {
        if ($fio != "") $this->fio = $fio;
    }

    public function setPhoneIfNotEmpty($phone)
    {
        if ($phone != "") $this->phone = $phone;
    }

    public function setAddressIfNotEmpty($address)
    {
        if ($address != "") $this->address = $address;
    }

    public function setDateBirthIfNotEmpty($date_birth)
    {
        if ($date_birth != "") $this->date_birth = $date_birth;
    }

    public function setDateEmploymentIfNotEmpty($date_employment)
    {
        if ($date_employment != "") $this->date_employment = $date_employment;
    }

    public function setDateDismissalIfNotEmpty($date_dismissal)
    {
        if ($date_dismissal != "") $this->date_dismissal = $date_dismissal;
    }

    public function setReasonDismissalIfNotEmpty($reason_dismissal)
    {
        if ($reason_dismissal != "") $this->reason_dismissal = $reason_dismissal;
    }

    public function setGroup(Group $group)
    {
        if ($group->exists) $this->group_id = $group->getId();
        else $this->group_id = null;
    }

    public function setPositionIfNotEmpty(Position $position)
    {
        if ($position->exists) $this->position_id = $position->getId();
    }

    public function createJournalOnMonth(Carbon $data)
    {
        for ($i = 1; $i <= $data->lastOfMonth()->day; $i++) {
            $journalDateDay = $data->setDay($i);
            if ($this->getJournal()->whereDate("create_date", "=", $journalDateDay)->count() == 0) {
                JournalStaff::make($this, Visit::getById(0), $journalDateDay)->save();
            }
        }
    }
    //</editor-fold>

    //<editor-fold desc="Search Branch">
    public static function getById($id): Staff
    {
        return Staff::where("id", $id)->first() ?? new Staff();
    }

    //</editor-fold>

    public static function make($fio, $phone, $address, $date_birth, $date_employment, $date_dismissal, $reason_dismissal, Group $group, Position $position)
    {
        return Staff::factory([
            "fio" => $fio,
            "phone" => $phone,
            "address" => $address,
            "date_birth" => $date_birth,
            "date_employment" => $date_employment,
            "date_dismissal" => $date_dismissal,
            "reason_dismissal" => $reason_dismissal,
            "group_id" => $group->getId(),
            "position_id" => $position->getId(),
        ])->make();
    }
}
