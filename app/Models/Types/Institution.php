<?php

namespace App\Models\Types;

use App\Models\Branch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    use HasFactory;

    //<editor-fold desc="Setting">
    public $timestamps = false;
    //</editor-fold>

    //<editor-fold desc="Get Attribute">

    public static function getById($id): Institution
    {
        return Institution::where("id", $id)->first() ?? new Institution();
    }

    public static function make($name)
    {
        return Branch::factory(["name" => $name])->make();
    }
    //</editor-fold>

    //<editor-fold desc="Set Attribute">

    public function getId()
    {
        return $this->id;
    }
    //</editor-fold>

    //<editor-fold desc="Search Branch">

    public function getName()
    {
        return $this->name;
    }

    //</editor-fold>

    public function setNameIfNotEmpty($name)
    {
        if ($name != "") {
            $this->name = $name;
        }
    }
}
