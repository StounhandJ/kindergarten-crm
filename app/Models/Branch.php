<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
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
    //</editor-fold>

    //<editor-fold desc="Set Attribute">
    public function setNameIfNotEmpty($name)
    {
        if ($name!="") $this->name = $name;
    }
    //</editor-fold>

    //<editor-fold desc="Search Branch">
    public static function getBranchById($id) : Branch
    {
        return Branch::where("id", $id)->first() ?? new Branch();
    }
    //</editor-fold>

    public static function create($name)
    {
        return Branch::factory(["name"=>$name] )->make();
    }
}
