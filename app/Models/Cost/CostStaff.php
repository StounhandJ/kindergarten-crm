<?php

namespace App\Models\Cost;

use App\Models\Staff;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Carbon;

class CostStaff extends Pivot
{
    use HasFactory;

    public $incrementing = false;

    public $timestamps = false;

    public static function getByStaffAndMonthLosses(Staff $staff, Carbon $month): Collection
    {
        return CostStaff::query()
            ->join("costs", "costs.id", "=", "cost_id")
            ->whereDate("costs.created_at", ">=", $month->firstOfMonth())
            ->whereDate("costs.created_at", "<=", $month->lastOfMonth())
            ->where("costs.is_profit", "=", false)
            ->where("staff_id", "=", $staff->getId())
            ->get();
    }

    public function getAmount()
    {
        return $this->getCost()->getAmount();
    }

    public function getCost()
    {
        return Cost::getById($this->cost_id);
    }
}
