<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
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
    //</editor-fold>

    //<editor-fold desc="Search Branch">
    public static function getById($id): Visit
    {
        return Visit::where("id", $id)->first() ?? new Visit();
    }
    //</editor-fold>
}
