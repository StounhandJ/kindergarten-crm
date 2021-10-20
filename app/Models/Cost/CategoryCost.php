<?php

namespace App\Models\Cost;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class CategoryCost extends Model
{
    use HasFactory;

    //<editor-fold desc="Setting">
    public const ZP = 1;
    public const CHILD_PAY = 2;

    protected $fillable = [
        'name',
        'is_profit',
        'is_set_child',
        'is_set_staff',
        'is_active'
    ];

    public $timestamps = true;

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

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

    public function isProfit()
    {
        return $this->is_profit;
    }

    public function isSetChild()
    {
        return $this->is_set_child;
    }

    public function isSetStaff()
    {
        return $this->is_set_staff;
    }

    public function isActive()
    {
        return $this->is_active;
    }
    //</editor-fold>

    //<editor-fold desc="Set Attribute">


    public function setNameIfNotEmpty($name): static
    {
        if ($name != "") {
            $this->name = $name;
        }

        return $this;
    }

    public function setIsProfitIfNotEmpty($is_profit): static
    {
        if (!is_null($is_profit)) {
            $this->is_profit = $is_profit;
        }

        return $this;
    }

    public function setIsSetChildIfNotEmpty($is_set_child): static
    {
        if (!is_null($is_set_child)) {
            $this->is_set_child = $is_set_child;
        }

        return $this;
    }

    public function setIsSetStaffIfNotEmpty($is_set_staff): static
    {
        if (!is_null($is_set_staff)) {
            $this->is_set_staff = $is_set_staff;
        }

        return $this;
    }

    public function setIsActiveIfNotEmpty($is_active): static
    {
        if (!is_null($is_active)) {
            $this->is_active = $is_active;
        }

        return $this;
    }


    //</editor-fold>

    //<editor-fold desc="Search Branch">

    public static function getById($id): CategoryCost|Model
    {
        return CategoryCost::query()->where("id", $id)->firstOrNew();
    }

    public static function getAllActive(): Collection
    {
        return CategoryCost::query()->where("is_active", true)->orderBy("updated_at", "desc")->get();
    }

    //</editor-fold>

    public static function make($name, $is_profit, $is_set_child, $is_set_staff)
    {
        return CategoryCost::query()->make([
            "name" => $name,
            "is_profit" => $is_profit,
            "is_set_child" => $is_set_child,
            "is_set_staff" => $is_set_staff,
            "is_active" => true
        ]);
    }

    public static function getBaseArrayCategory(): array
    {
        return [
            [
                "id" => 1,
                "name" => "ЗП",
                "is_profit" => false,
                "is_set_child" => false,
                "is_set_staff" => true,
                "is_active" => true
            ],
            [
                "id" => 2,
                "name" => "Оплата за детей",
                "is_profit" => true,
                "is_set_child" => true,
                "is_set_staff" => false,
                "is_active" => true
            ]
        ];
    }
}
