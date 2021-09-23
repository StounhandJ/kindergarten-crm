<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use HasFactory;
    use SoftDeletes;

    //<editor-fold desc="Setting">
    public $timestamps = false;

    protected $hidden = ['delete_at'];

    protected $appends = ['branch_name'];

    public static function getById($id): Group
    {
        return Group::where("id", $id)->first() ?? new Group();
    }
    //</editor-fold>

    //<editor-fold desc="Get Attribute">

    public static function make($name, $children_age, Branch $branch)
    {
        return Group::factory([
            "name" => $name,
            "children_age" => $children_age,
            "branch_id" => $branch->getId()
        ])->make();
    }

    public function getBranchNameAttribute()
    {
        return $this->getBranch()->getName();
    }

    public function getBranch(): Branch
    {
        return $this->belongsTo(Branch::class, "branch_id")->getResults() ?? new Branch();
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

    public function getChildrenAge()
    {
        return $this->children_age;
    }
    //</editor-fold>

    //<editor-fold desc="Search Branch">

    public function setNameIfNotEmpty($name)
    {
        if ($name != "") {
            $this->name = $name;
        }
    }

    //</editor-fold>

    public function setBranchIfNotEmpty(Branch $branch)
    {
        if ($branch->exists) {
            $this->branch_id = $branch->getId();
        }
    }

    public function setChildrenAgeIfNotEmpty($children_age)
    {
        if ($children_age != "") {
            $this->children_age = $children_age;
        }
    }


}
