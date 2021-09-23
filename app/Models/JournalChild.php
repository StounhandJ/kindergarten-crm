<?php

namespace App\Models;

use App\Models\Types\Visit;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalChild extends Model
{
    use HasFactory;

    //<editor-fold desc="Setting">
    public $timestamps = false;
    //</editor-fold>

    //<editor-fold desc="Get Attribute">

    public static function make(Child $child, Visit $visit, Carbon $date)
    {
        return JournalChild::factory([
            "child_id" => $child->getId(),
            "visit_id" => $visit->getId(),
            "create_date" => $date
        ])->make();
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

    public function getChild(): Child
    {
        return Child::getById($this->child_id);
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
        return $this;
    }
}
