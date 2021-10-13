<?php

namespace App\Models\Cost;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryCost extends Model
{
    use HasFactory;

    //<editor-fold desc="Setting">
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
        if ($is_profit != "") {
            $this->is_profit = $is_profit;
        }

        return $this;
    }

    //</editor-fold>

    //<editor-fold desc="Search Branch">

    public static function getById($id): CategoryCost | Model
    {
        return CategoryCost::query()->where("id", $id)->firstOrNew();
    }

    //</editor-fold>

    public static function make($name, $is_profit)
    {
        return CategoryCost::factory([
            "name" => $name,
            "is_profit" => $is_profit
        ])->make();
    }
}
