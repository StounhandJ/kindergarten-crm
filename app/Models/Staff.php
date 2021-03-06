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

    protected $fillable = [
        'fio',
        'phone',
        'address',
        'date_birth',
        'date_employment',
        'deleted_at',
        'reason_dismissal',
        'salary',
        'group_id',
        'branch_id',
        'position_id',
        'user_id'
    ];

    protected $hidden = ['deleted_at', 'created_at', 'updated_at'];

    protected $appends = [
        'id_branch',
        "branch_name",
        "group_name",
        "position_name",
        "date_dismissal",
        "login",
        "password",
        "vacation_total",
        "vacation_off",
        "vacation_for_today"
    ];

    public function getIdBranchAttribute()
    {
        $group = $this->getGroup();
        if ($group->exists)
            return $this->getGroup()->getBranch()->getId();
        return $this->branch_id;
    }

    public function getBranchNameAttribute()
    {
        $group = $this->getGroup();
        if ($group->exists)
            return $this->getGroup()->getBranch()->getName();
        return $this->getBranch()->getName();
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

    public function getVacationTotalAttribute()
    {
        return round($this->getDateEmployment()->range(Carbon::now())->count()/(365/14),1);
    }

    public function getVacationOffAttribute()
    {
        $journals = $this->getAllJournal();
        return $journals->filter(fn($journal) => $journal->getVisit()->IsVacation())->count();
    }

    public function getVacationForTodayAttribute()
    {
        return $this->getVacationTotalAttribute()-$this->getVacationOffAttribute();
    }
    //</editor-fold>

    //<editor-fold desc="Get Attribute">

    public function getId()
    {
        return $this->id;
    }

    public function getGroup(): Group
    {
        return $this->belongsTo(Group::class, "group_id")->getResults() ?? new Group();
    }

    public function getBranch(): Branch
    {
        return $this->belongsTo(Branch::class, "branch_id")->getResults() ?? new Branch();
    }

    public function getPosition(): Position
    {
        return $this->belongsTo(Position::class, "position_id")->getResults();
    }

    public function getDateDismissal()
    {
        return $this->deleted_at;
    }

    public function isDismissal(): bool
    {
        return !is_null($this->getDateDismissal());
    }

    public function getUser(): User
    {
        return $this->hasOne(User::class, "id", "user_id")->getResults();
    }

    public function getAllJournal(): Collection
    {
        return $this->getJournal()->get()->sortBy("create_date");
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

    public function getDateBirth(): ?Carbon
    {
        return Carbon::make($this->date_birth);
    }

    public function getDateEmployment(): ?Carbon
    {
        return Carbon::make($this->date_employment);
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

    public function setBranchIfNotEmpty(Branch $branch)
    {
        if ($branch->exists) {
            $this->branch_id = $branch->getId();
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

    public static function getById($id, $withTrashed = false): \Illuminate\Database\Eloquent\Builder|Staff
    {
        if ($withTrashed)
            return Staff::withTrashed()->where("id", $id)->firstOrNew();
        return Staff::query()->where("id", $id)->firstOrNew();
    }

    public static function getByUserId($id): \Illuminate\Database\Eloquent\Builder|Staff
    {
        return Staff::query()->where("user_id", $id)->firstOrNew();
    }

    public static function getByFio($fio): \Illuminate\Database\Eloquent\Builder|Staff
    {
        return Staff::withTrashed()->where("fio", $fio)->firstOrNew();
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
        Branch $branch,
        Position $position,
        $login,
        $password
    ) {
        $user = User::make($login, $password);
        $user->save();
        return Staff::query()->make([
            "fio" => $fio,
            "phone" => $phone,
            "address" => $address,
            "date_birth" => $date_birth,
            "date_employment" => $date_employment,
            "deleted_at" => $date_dismissal,
            "reason_dismissal" => $reason_dismissal,
            "salary" => $salary,
            "group_id" => $group->getId(),
            "branch_id" => $branch->getId(),
            "position_id" => $position->getId(),
            "user_id" => $user->getId()
        ]);
    }
}
