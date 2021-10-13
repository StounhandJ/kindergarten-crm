<?php

namespace App\Models\Cost;

use App\Models\Child;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Carbon;

class ChildCost extends Pivot
{
    use HasFactory;

    public $incrementing = false;

    public $timestamps = false;

    public static function getByChildAndMonthProfit(Child $child, Carbon $month): Collection
    {
        return ChildCost::query()
            ->select(["child_cost.*"])
            ->join("costs", "costs.id", "=", "cost_id")
            ->whereDate("costs.created_at", ">=", $month->firstOfMonth())
            ->whereDate("costs.created_at", "<=", $month->lastOfMonth())
            ->join('category_costs', 'category_costs.id', '=', 'costs.category_id')
            ->where("category_costs.is_profit", "=", true)
            ->where("child_id", "=", $child->getId())
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
