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
    use HasFactory;
    use SoftDeletes;

    //<editor-fold desc="Setting">
    protected $table = "staff";

    protected $hidden = ['deleted_at', 'created_at', 'updated_at'];

    protected $appends = [
        'branch_id',
        "branch_name",
        "group_name",
        "position_name",
        "date_dismissal",
        "login",
        "password"
    ];

    public function getBranchIdAttribute()
    {
        return $this->getGroup()->getBranch()->getId();
    }

    public function getBranchNameAttribute()
    {
        return $this->getGroup()->getBranch()->getName();
    }

    public function getLoginAttribute()
    {
        return $this->getUser()->getLogin();
    }

    public function getGroupNameAttribute()
    {
        return $this->getGroup()->getName();
    }

    public function getPositionNameAttribute()
    {
        return $this->getPosition()->getName();
    }

    public function getPasswordAttribute()
    {
        return "";
    }

    public function getDateDismissalAttribute()
    {
        return $this->getDateDismissal();
    }
    //</editor-fold>

    //<editor-fold desc="Get Attribute">

    public function getId()
    {
        return $this->id;
    }

    public function getGroup()
    {
        return $this->belongsTo(Group::class, "group_id")->getResults() ?? new Group();
    }

    public function getPosition()
    {
        return $this->belongsTo(Position::class, "position_id")->getResults();
    }

    public function getDateDismissal()
    {
        return $this->deleted_at;
    }

    public function getUser(): User
    {
        return $this->hasOne(User::class, "id", "user_id")->getResults();
    }

    public function getJournalOnMonth(Carbon $data): Collection
    {
        return $this->getJournal()->whereDate("create_date", ">=", $data->firstOfMonth())
            ->whereDate("create_date", "<=", $data->lastOfMonth())->get()->sortBy("create_date");
    }

    public function getJournal(): HasMany
    {
        return $this->hasMany(JournalStaff::class);
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

    public function getReasonDismissal()
    {
        return $this->reason_dismissal;
    }

    public function getSalary()
    {
        return $this->salary;
    }
    //</editor-fold>

    //<editor-fold desc="Set Attribute">

    public function setFioIfNotEmpty($fio)
    {
        if ($fio != "") {
            $this->fio = $fio;
        }
    }

    public function setPhoneIfNotEmpty($phone)
    {
        if ($phone != "") {
            $this->phone = $phone;
        }
    }

    public function setAddressIfNotEmpty($address)
    {
        if ($address != "") {
            $this->address = $address;
        }
    }

    public function setDateBirthIfNotEmpty($date_birth)
    {
        if ($date_birth != "") {
            $this->date_birth = $date_birth;
        }
    }

    public function setDateEmploymentIfNotEmpty($date_employment)
    {
        if ($date_employment != "") {
            $this->date_employment = $date_employment;
        }
    }

    public function setDateDismissal($deleted_at)
    {
        $this->deleted_at = $deleted_at;
    }

    public function setReasonDismissalIfNotEmpty($reason_dismissal)
    {
        if ($reason_dismissal != "") {
            $this->reason_dismissal = $reason_dismissal;
        }
    }

    public function setSalaryIfNotEmpty($salary)
    {
        if ($salary != "") {
            $this->salary = $salary;
        }
    }

    public function setGroup(Group $group)
    {
        if ($group->exists) {
            $this->group_id = $group->getId();
        } else {
            $this->group_id = null;
        }
    }

    public function setPasswordIfNotEmpty($password)
    {
        if ($password != "") {
            $this->getUser()
                ->setPassword($password)
                ->save();
        }
    }

    public function setPositionIfNotEmpty(Position $position)
    {
        if ($position->exists) {
            $this->position_id = $position->getId();
        }
    }

    public function setLoginIfNotEmpty($login)
    {
        if ($login != "") {
            $this->getUser()
                ->setLogin($login)
                ->save();
        }
    }
    //</editor-fold>

    //<editor-fold desc="Search Branch">

    public static function getById($id): Staff
    {
        return Staff::where("id", $id)->first() ?? new Staff();
    }

    public static function getByUserId($id): Staff
    {
        return Staff::where("user_id", $id)->first() ?? new Staff();
    }

    //</editor-fold>

    public static function make(
        $fio,
        $phone,
        $address,
        $date_birth,
        $date_employment,
        $date_dismissal,
        $reason_dismissal,
        $salary,
        Group $group,
        Position $position,
        $login,
        $password
    ) {
        $user = User::make($login, $password);
        $user->save();
        return Staff::factory([
            "fio" => $fio,
            "phone" => $phone,
            "address" => $address,
            "date_birth" => $date_birth,
            "date_employment" => $date_employment,
            "deleted_at" => $date_dismissal,
            "reason_dismissal" => $reason_dismissal,
            "salary" => $salary,
            "group_id" => $group->getId(),
            "position_id" => $position->getId(),
            "user_id" => $user->getId()
        ])->make();
    }
}
