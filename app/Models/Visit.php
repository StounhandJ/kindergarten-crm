<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\Pure;

class Visit extends Model
{
    use HasFactory;

    //<editor-fold desc="Setting">
    public $timestamps = false;

    public const NOT_SELECTED = 0;
    public const WHOLE_DAT = 1;
    public const HALF_DAT = 2;
    public const SICK = 3;
    public const VACATION = 4;
    public const TRUANCY = 5;

    //</editor-fold>

    //<editor-fold desc="Get Attribute">
    public function getId()
    {
        return $this->id;
    }

    #[Pure] public function IsNotSelected(): bool
    {
        return $this->getId() == Visit::NOT_SELECTED;
    }

    #[Pure] public function IsWholeDat(): bool
    {
        return $this->getId() == Visit::WHOLE_DAT;
    }

    #[Pure] public function IsHalfDat(): bool
    {
        return $this->getId() == Visit::HALF_DAT;
    }

    #[Pure] public function IsSick(): bool
    {
        return $this->getId() == Visit::SICK;
    }

    #[Pure] public function IsVacation(): bool
    {
        return $this->getId() == Visit::VACATION;
    }

    #[Pure] public function IsTruancy(): bool
    {
        return $this->getId() == Visit::TRUANCY;
    }
    //</editor-fold>

    //<editor-fold desc="Search Branch">
    public static function getById($id): Visit
    {
        return Visit::where("id", $id)->first() ?? new Visit();
    }
    //</editor-fold>
}
