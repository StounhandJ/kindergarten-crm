<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory;
    use SoftDeletes;

    //<editor-fold desc="Setting">
    protected $fillable = [
        'name'
    ];
    public $timestamps = true;
    protected $hidden = ['deleted_at', 'created_at', 'updated_at'];
    //</editor-fold>

    //<editor-fold desc="Get Attribute">

    public static function getById($id): Branch
    {
        return Branch::where("id", $id)->first() ?? new Branch();
    }

    public static function make($name)
    {
        return Branch::query()->make(["name" => $name]);
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
