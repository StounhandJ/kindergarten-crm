<?php

namespace App\Models\Cost;

use App\Models\Child;
use App\Models\Staff;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;
use phpDocumentor\Reflection\Types\Boolean;

class Cost extends Model
{
    use HasFactory;

    //<editor-fold desc="Setting">
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    protected $appends = ['date', 'staff', 'child', 'branch_name', 'category_name'];

    public function getBranchNameAttribute()
    {
        $pr = $this->getStaffAttribute() ?? $this->getChildAttribute();
        return $pr ? $pr->getBranchNameAttribute() : "";
    }

    public function getCategoryNameAttribute()
    {
        return $this->getCategoryCost()->getName();
    }

    public function getStaffAttribute()
    {
        return $this->getStaff();
    }

    public function getChildAttribute()
    {
        return $this->getChildren();
    }

    public function getDateAttribute()
    {
        return $this->getDate()->format("Y-m-d");
    }
    //</editor-fold>

    //<editor-fold desc="Get Attribute">

    public function getDate(): Carbon
    {
        return Carbon::make($this->created_at);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getStaff()
    {
        return $this->staff()->first();
    }

    public function getChildren()
    {
        return $this->children()->first();
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getCategoryCost(): CategoryCost
    {
        return CategoryCost::getById($this->category_id);
    }

    public function getIsProfit()
    {
        return $this->getCategoryCost()->isProfit();
    }
    //</editor-fold>

    //<editor-fold desc="Set Attribute">


    //</editor-fold>

    //<editor-fold desc="Search Branch">

    public static function getById($id): Cost | Model
    {
        return Cost::query()->where("id", $id)->firstOrNew();
    }

    public static function getBuilderByIncomeAndMonth(bool $income, Carbon $month, bool $orderByUpdate = false): Builder
    {
        $builder = Cost::query()
            ->select(["costs.*"])
            ->whereDate("costs.created_at", ">=", $month->firstOfMonth())
            ->whereDate("costs.created_at", "<=", $month->lastOfMonth())
            ->join('category_costs', 'category_costs.id', '=', 'category_id')
            ->where("category_costs.is_profit", "=", $income);
        if ($orderByUpdate)
            $builder->orderBy("costs.updated_at", "desc");
        return $builder;
    }

    //</editor-fold>


    private function attachChildOrStaff(Child $child, Staff $staff)
    {
        if ($child->exists) {
            $this->children()->attach($child);
        } elseif ($staff->exists) {
            $this->staff()->attach($staff);
        }

        return $this;
    }

    public function children(): BelongsToMany
    {
        return $this->belongsToMany(Child::class)->using(ChildCost::class);
    }

    public function staff(): BelongsToMany
    {
        return $this->belongsToMany(Staff::class)->using(CostStaff::class);
    }

    public static function create(CategoryCost $categoryCost, $amount, $comment, Child $child, Staff $staff, Carbon $month): Cost
    {
        return Cost::factory([
            "category_id"=>$categoryCost->getId(),
            "amount" => $amount,
            "comment" => $comment,
            "created_at" => $month
        ])->create()->attachChildOrStaff($child, $staff);
    }
}
