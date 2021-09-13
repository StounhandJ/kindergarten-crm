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
    protected $appends = ['date', 'staff', 'child'];

    public function getDateAttribute()
    {
        return $this->getDate()->format("Y-m-d");
    }

    public function getStaffAttribute()
    {
        return $this->getStaff();
    }

    public function getChildAttribute()
    {
        return $this->getChildren();
    }
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

    public function getDate(): Carbon
    {
        return Carbon::make($this->created_at);
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function getChildren()
    {
        return $this->children()->first();
    }

    public function getStaff()
    {
        return $this->staff()->first();
    }

    public function children(): BelongsToMany
    {
        return $this->belongsToMany(Child::class)->using(ChildCost::class);
    }

    public function staff(): BelongsToMany
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

    public static function getBuilderByIncome(bool $income): Builder
    {
        return Cost::query()->where("is_profit", "=", $income);
    }

    //</editor-fold>

    public static function profit($amount, $comment, Child $child, Staff $staff): Cost
    {
        return Cost::factory([
            "amount"=>$amount,
            "comment"=>$comment,
        ])->profit()
            ->create()
            ->attachChildOrStaff($child, $staff);
    }

    public static function losses($amount, $comment, Child $child, Staff $staff): Cost
    {
        return Cost::factory([
            "amount"=>abs($amount),
            "comment"=>$comment,
        ])->losses()
            ->create()
            ->attachChildOrStaff($child, $staff);
    }
}