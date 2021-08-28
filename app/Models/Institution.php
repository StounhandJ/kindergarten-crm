<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    use HasFactory;

    public function getId()
    {
        return $this->id;
    }

    public static function getInstitutionById($id) : Institution
    {
        return Institution::where("id", $id)->first() ?? new Institution();
    }
}
