<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    public $timestamps = false;

    public static function getBranchById($id) : Branch
    {
        return Branch::where("id", $id)->first() ?? new Branch();
    }

    public function getId()
    {
        return $this->id;
    }
}
