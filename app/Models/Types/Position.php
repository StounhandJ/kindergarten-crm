<?php

namespace App\Models\Types;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    //<editor-fold desc="Setting">
    public $timestamps = false;
    //</editor-fold>

    //<editor-fold desc="Get Attribute">
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEName()
    {
        return $this->e_name;
    }
    //</editor-fold>

    //<editor-fold desc="Set Attribute">
    public function setNameIfNotEmpty($name)
    {
        if ($name!="") $this->name = $name;
    }
    //</editor-fold>

    //<editor-fold desc="Search Branch">
    public static function getById($id) : Position
    {
        return Position::where("id", $id)->first() ?? new Position();
    }
    //</editor-fold>

    public static function make($name)
    {
        return Position::factory(["name"=>$name] )->make();
    }
}
