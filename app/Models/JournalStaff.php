<?php

namespace App\Models;

use App\Models\Types\Visit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class JournalStaff extends Model
{
    use HasFactory;

    //<editor-fold desc="Setting">
    public $timestamps = false;

    protected $fillable = [
        'staff_id',
        'visit_id',
        'create_date'
    ];
    //</editor-fold>

    //<editor-fold desc="Get Attribute">

    public static function make(Staff $staff, Visit $visit, Carbon $date)
    {
        return JournalStaff::query()->make([
            "staff_id" => $staff->getId(),
            "visit_id" => $visit->getId(),
            "create_date" => $date
        ]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getVisit(): Visit
    {
        return Visit::getById($this->visit_id);
    }

    public function getVisitId()
    {
        return $this->visit_id;
    }

    public function getStaff(): Staff
    {
        return Staff::getById($this->staff_id);
    }
    //</editor-fold>

    //<editor-fold desc="Set Attribute">

    public function getCreateDate()
    {
        return Carbon::make($this->create_date);
    }

    //</editor-fold>

    public function setVisitIfNotEmpty(Visit $visit)
    {
        if ($visit->exists) {
            $this->visit_id = $visit->getId();
        }
    }
}
