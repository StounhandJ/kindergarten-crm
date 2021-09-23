<?php

namespace App\Models\Cost;

use App\Models\Child;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Cost extends Model
{
    use HasFactory;

    //<editor-fold desc="Setting">
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    protected $appends = ['date', 'staff', 'child', 'branch_name'];

    public static function getById($id): Cost
    {
        return Cost::where("id", $id)->first() ?? new Cost();
    }

    public static function getBuilderByIncomeAndMonth(bool $income, Carbon $month): Builder
    {
        return Cost::query()->where("is_profit", "=", $income)->whereDate("created_at", ">=", $month->firstOfMonth())
            ->whereDate("created_at", "<=", $month->lastOfMonth());
    }

    public static function profit($amount, $comment, Child $child, Staff $staff): Cost
    {
        return Cost::factory([
            "amount" => $amount,
            "comment" => $comment,
        ])->profit()
            ->create()
            ->attachChildOrStaff($child, $staff);
    }

    public static function losses($amount, $comment, Child $child, Staff $staff): Cost
    {
        return Cost::factory([
            "amount" => $amount,
            "comment" => $comment,
        ])->losses()
            ->create()
            ->attachChildOrStaff($child, $staff);
    }
    //</editor-fold>

    //<editor-fold desc="Get Attribute">

    public function getDateAttribute()
    {
        return $this->getDate()->format("Y-m-d");
    }

    public function getDate(): Carbon
    {
        return Carbon::make($this->created_at);
    }

    public function getBranchNameAttribute()
    {
        $pr = $this->getStaffAttribute() ?? $this->getChildAttribute();
        return $pr ? $pr->getBranchNameAttribute() : "";
    }

    public function getStaffAttribute()
    {
        return $this->getStaff();
    }

    public function getStaff()
    {
        return $this->staff()->first();
    }

    public function staff(): BelongsToMany
    {
        return $this->belongsToMany(Staff::class)->using(CostStaff::class);
    }

    public function getChildAttribute()
    {
        return $this->getChildren();
    }

    public function getChildren()
    {
        return $this->children()->first();
    }

    public function children(): BelongsToMany
    {
        return $this->belongsToMany(Child::class)->using(ChildCost::class);
    }
    //</editor-fold>

    //<editor-fold desc="Set Attribute">

    public function getId()
    {
        return $this->id;
    }
    //</editor-fold>

    //<editor-fold desc="Search Branch">

    public function getAmount()
    {
        return $this->amount;
    }

    public function getIsProfit()
    {
        return $this->is_profit;
    }

    //</editor-fold>

    public function getComment()
    {
        return $this->comment;
    }

    private function attachChildOrStaff(Child $child, Staff $staff)
    {
        if ($child->exists) {
            $this->children()->attach($child);
        } else {
            if ($staff->exists) {
                $this->staff()->attach($staff);
            }
        }

        return $this;
    }
}
