<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    public $timestamps = false;

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

    public function setNameIfNotEmpty($name)
    {
        if ($name!="") $this->name = $name;
    }

    public function setChildrenAgeIfNotEmpty($children_age)
    {
        if ($children_age!="") $this->children_age = $children_age;
    }

     public function setDepartmentIfNotEmpty(Branch $branch)
    {
        if ($branch->exists) $this->branch_id = $branch->getId();
    }

}
