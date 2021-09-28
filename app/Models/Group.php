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
    public $timestamps = true;

    protected $hidden = ['delete_at', 'created_at', 'updated_at'];

    protected $appends = ['branch_name'];

    public function getBranchNameAttribute()
    {
        return $this->getBranch()->getName();
    }
    //</editor-fold>

    //<editor-fold desc="Get Attribute">

    public function getBranch(): Branch
    {
        return $this->belongsTo(Branch::class, "branch_id")->getResults() ?? new Branch();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getChildrenAge()
    {
        return $this->children_age;
    }

    //</editor-fold>

    //<editor-fold desc="Set Attribute">

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

    public function setNameIfNotEmpty($name)
    {
        if ($name != "") {
            $this->name = $name;
        }
    }
    //</editor-fold>

    //<editor-fold desc="Search Branch">

    public static function getById($id): Group
    {
        return Group::where("id", $id)->firstOrNew();
    }

    //</editor-fold>

    public static function make($name, $children_age, Branch $branch)
    {
        return Group::factory([
            "name" => $name,
            "children_age" => $children_age,
            "branch_id" => $branch->getId()
        ])->make();
    }
}
