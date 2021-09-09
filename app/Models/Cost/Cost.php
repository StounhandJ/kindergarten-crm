<?php

namespace App\Models\Cost;

use App\Models\Child;
use App\Models\Staff;
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

    public function children(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Child::class)->using(ChildCost::class);
    }

    public function staff(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Staff::class)->using(CostStaff::class);
    }
    //</editor-fold>

    //<editor-fold desc="Set Attribute">
    private function attachChildOrStaff(Child $child, Staff $staff)
    {
        if ($child->exists)
            $this->children()->attach($child);

        else if ($staff->exists)
            $this->staff()->attach($staff);

        return $this;
    }
    //</editor-fold>

    //<editor-fold desc="Search Branch">
    public static function getById($id): Cost
    {
        return Cost::where("id", $id)->first() ?? new Cost();
    }

    //</editor-fold>

    public static function profit($amount, Child $child, Staff $staff): Cost
    {
        return Cost::factory([
            "amount"=>$amount
        ])->profit()
            ->create()
            ->attachChildOrStaff($child, $staff);
    }

    public static function losses($amount, Child $child, Staff $staff): Cost
    {
        return Cost::factory([
            "amount"=>$amount
        ])->losses()
            ->create()
            ->attachChildOrStaff($child, $staff);
    }
}
