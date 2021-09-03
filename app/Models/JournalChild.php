<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalChild extends Model
{
    use HasFactory;

    //<editor-fold desc="Get Attribute">
    public function getId()
    {
        return $this->id;
    }

    public function getVisitId()
    {
        return $this->visit_id;
    }

    public function getCreateDate()
    {
        return $this->create_date;
    }
    //</editor-fold>

    //<editor-fold desc="Set Attribute">
    public function setVisitIfNotEmpty(Visit $visit)
    {
        if ($visit->exists) $this->visit_id = $visit->getId();
    }
    //</editor-fold>

    public static function make(Visit $visit)
    {
        return Group::factory([
            "visit_id"=>$visit->getId()
        ] )->make();
    }
}
