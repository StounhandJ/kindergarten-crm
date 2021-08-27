<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    //<editor-fold desc="Setting">
    public $timestamps = false;

    protected $appends = ['branch_name'];

    public function getBranchNameAttribute(): string
    {
        return $this->getBranch()->getName();
    }
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

    public function getChildrenAge()
    {
        return $this->children_age;
    }

    public function getBranch(): Branch
    {
        return $this->belongsTo(Branch::class, "branch_id")->getResults();
    }
    //</editor-fold>

    //<editor-fold desc="Set Attribute">
    public function setNameIfNotEmpty($name)
    {
        if ($name!="") $this->name = $name;
    }

    public function setDepartmentIfNotEmpty(Branch $branch)
    {
        if ($branch->exists) $this->branch_id = $branch->getId();
    }
    //</editor-fold>

    //<editor-fold desc="Search Branch">
    public static function getGroupById($id) : Group
    {
        return Group::where("id", $id)->first() ?? new Group();
    }
    //</editor-fold>

    public function setChildrenAgeIfNotEmpty($children_age)
    {
        if ($children_age!="") $this->children_age = $children_age;
    }



}
