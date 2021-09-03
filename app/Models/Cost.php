<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cost extends Model
{
    use HasFactory;

    //<editor-fold desc="Setting">
    //</editor-fold>

    //<editor-fold desc="Get Attribute">
    public function getId()
    {
        return $this->id;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getIsProfit()
    {
        return $this->is_profit;
    }

    public function getDate()
    {
        return $this->created_at;
    }
    //</editor-fold>

    //<editor-fold desc="Set Attribute">
    // Не изменяются
    //</editor-fold>

    //<editor-fold desc="Search Branch">
    public static function getById($id): Cost
    {
        return Cost::where("id", $id)->first() ?? new Cost();
    }

    //</editor-fold>

    public static function profit($amount): Cost
    {
        return Cost::factory([
            "amount"=>$amount
        ])->profit()->create();
    }

    public static function losses($amount): Cost
    {
        return Cost::factory([
            "amount"=>$amount
        ])->losses()->create();
    }
}
