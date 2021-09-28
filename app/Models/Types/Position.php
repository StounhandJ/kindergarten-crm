<?php

namespace App\Models\Types;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    //<editor-fold desc="Setting">
    public $timestamps = false;

    public const DIRECTOR = 1;
    public const SENIOR_TUTOR = 2;
    public const TUTOR = 3;
    public const COOK = 4;
    //</editor-fold>

    //<editor-fold desc="Get Attribute">

    public static function getById($id): Position
    {
        return Position::where("id", $id)->first() ?? new Position();
    }

    public static function make($name)
    {
        return Position::factory(["name" => $name])->make();
    }

    public function getId()
    {
        return $this->id;
    }
    //</editor-fold>

    //<editor-fold desc="Set Attribute">

    public function getName()
    {
        return $this->name;
    }
    //</editor-fold>

    //<editor-fold desc="Search Branch">

    public function getEName()
    {
        return $this->e_name;
    }

    //</editor-fold>

    public function setNameIfNotEmpty($name)
    {
        if ($name != "") {
            $this->name = $name;
        }
    }
}
