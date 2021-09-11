<?php

namespace App\Models\Cost;

use App\Models\Child;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Carbon;

class ChildCost extends Pivot
{
    use HasFactory;

    public $incrementing = false;

    public $timestamps = false;

    public function getCost()
    {
        return Cost::getById($this->cost_id);
    }

    public function getAmount()
    {
        return $this->getCost()->getAmount();
    }

    public static function getByChildAndMonth(Child $child, Carbon $month): ChildCost
    {
        return ChildCost::query()
            ->join("costs", "costs.id", "=", "cost_id")
            ->whereDate("costs.created_at", ">=", $month->firstOfMonth())
            ->whereDate("costs.created_at", "<=", $month->lastOfMonth())
            ->where("child_id", "=", $child->getId())->firstOrNew();
    }
}
